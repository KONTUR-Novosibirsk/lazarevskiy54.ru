<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\App\Filters\QueryFilter;

class ShopTradeOffer extends Model
{
    use HasFactory;

    protected ?array $tradeOfferTree = null;

    protected ?array $tradeOfferAttributes = null;

    protected $fillable = [
        'name',
        'category_id',
        'sort'
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopProduct::class, 'trade_offer_id', 'id')
            ->with(['images', 'attributesValue']);
    }

    public function productsAttributes(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(ShopAttributeValue::class, ShopProduct::class,
            'trade_offer_id', 'product_id', 'id');
    }

    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ShopAttribute::class, 'shop_trade_offer_attribute',
            'trade_offer_id', 'attribute_id')
            ->withPivot(['sort'])
            ->orderBy('pivot_sort', 'ASC');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id');
    }

    public function scopePublicFilter(Builder $builder, QueryFilter $filter): Builder
    {
        return $filter->apply($builder);
    }

    public function makeOfferTree(): ?static
    {
        if (!settings('with_trade_offers', 'shop', false)) return null;
        $this->products = $this->products()->active()->with('attributesValue')->get();
        $products = $this->products->pluck('id');
        $attributes = $this->attributes()->with(['values' => fn($query) => $query->whereIn('product_id', $products)])->get();
        $attributesTree = $this->recursiveMakeBranches($attributes);

        if ($attributesTree) $this->searchLastProduct($attributesTree, []);

        $this->tradeOfferTree = $attributesTree;
        return $this;
    }

    protected function recursiveMakeBranches($attributes): ?array
    {
        $attributes = clone $attributes;
        $first = $attributes->shift();

        if (!$first) return null;

        $values = ['name' => $first->name, 'attributes' => []];

        foreach ($first->values as $value) {
            $array = array_filter($values['attributes'], function ($k) use ($value) {
                return $k['value'] == $value->value;
            });

            if (!$array) {
                $values['attributes'][] = [
                    'value' => $value->value,
                    'attribute_id' => $value->attribute_id,
                    'attribute' => $this->recursiveMakeBranches($attributes),
                    'current' => false,
                ];
            }
        }
        return $values;
    }

    protected function searchLastProduct(&$tree, $attributesForCondition)
    {
        $firstLeftProduct = null;
        foreach ($tree['attributes'] as &$attribute) {
            $condition = $attributesForCondition;
            $condition[] = [
                'value' => $attribute['value'],
                'attribute_id' => $attribute['attribute_id'],
            ];
            if ($attribute['attribute']) {
                $product = $this->searchLastProduct($attribute['attribute'], $condition);
                if (!isset($attribute['product'])) {
                    $attribute['product'] = $product;
                }
            } else {
                $attribute['condition'] = $condition;
                $attribute['product'] = $this->getProduct($condition);
            }
            if ($attribute['product'] && !$firstLeftProduct) $firstLeftProduct = $attribute['product'];
        }

        return $firstLeftProduct;
    }

    protected function getProduct($conditions): ?array
    {
        $products = $this->products->filter(function (ShopProduct $shopProduct, int $key) use ($conditions) {
            foreach ($conditions as $condition) {
                if (!$shopProduct->attributesValue->where('value', $condition['value'])
                    ->where('attribute_id', $condition['attribute_id'])->first()) {
                    return false;
                }
            }
            return true;
        });
        if ($product = $products->first()) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'url' => $product->createUrl($this->category),
            ];
        }
        return null;
    }

    public function getOfferAttributes(ShopProduct $shopProduct): ?array
    {
        if ($this->tradeOfferTree && $this->recursiveSearchBranch($this->tradeOfferTree, $shopProduct)) {
            return $this->tradeOfferAttributes;
        }
        return [];
    }

    // search current branch
    protected function recursiveSearchBranch(&$tree, ShopProduct $shopProduct): bool
    {
        foreach ($tree['attributes'] as &$branch) {
            $searchAttributes = $shopProduct->attributesValue->filter(function ($item) use ($branch) {
                if ($item->value == $branch['value']) {
                    return true;
                }
                return false;
            });

            if ($searchAttributes->first()) {
                $branch['current'] = true;
                $this->tradeOfferAttributes[] = $tree;
                if ($branch['attribute']) {
                    $this->recursiveSearchBranch($branch['attribute'], $shopProduct);
                }
                return true;
            }
        }
        return false;
    }

}
