<?php

namespace Modules\Shop\App\Models;

use App\Models\BaseModel;
use Database\Factories\ShopProductFactory;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\App\Contracts\CartableContract;
use Modules\Shop\App\Models\Scopes\ShopProductScopes;

class ShopProduct extends BaseModel implements Imageable, CartableContract, SitemapContract
{
    use HasFactory, HasImages, HasSeo, ShopProductScopes;

    public $attrs;

    public $offer;

    protected $fillable = [
        'title',
        'alias',
        'description',
        'category_id',
        'trade_offer_id',
        'price',
        'old_price',
        'active',
        'hit',
        'show_on_index_page',
        'show_on_shop_index_page',
        'sort'
    ];

    protected $casts = [
        'active' => 'boolean',
        'not_available' => 'boolean',
        'is_new' => 'boolean',
        'hit' => 'boolean',
        'show_on_index_page' => 'boolean',
        'show_on_shop_index_page' => 'boolean',
    ];

    protected static function newFactory(): ShopProductFactory
    {
        return ShopProductFactory::new();
    }

    public function previewImages(): ?\Illuminate\Database\Eloquent\Collection
    {
        return $this->getImagesByGroup('preview');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopCategory::class, 'category_id', 'id');
    }

    public function attributesValue(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopAttributeValue::class, 'product_id', 'id');
    }

    public function tradeOffer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopTradeOffer::class, 'trade_offer_id', 'id');
    }

    public function hashToCart(): string|false
    {
        $hash = [];
        $hash['id'] = $this->id;
        $hash['title'] = $this->title;
        $hash['price'] = $this->price;

        if ($this->attrs) {
            foreach ($this->attrs as $attr) {
                $hash[$attr['id']] = $attr['value'];
            }
        }

        if (!empty($this->offer)) {
            $hash['price'] = $this->offer['price'];
        }

        return mb_strcut(md5(json_encode($hash)), 0, 8);
    }

    public function cartAttributes(): array
    {
        $additionalAttrs = [];
        if ($this->attrs) {
            foreach ($this->attrs as $attr) {
                $additionalAttrs[$attr['id']] = $attr['value'];
            }
        }

        $attrs = [
            'id' => $this->getAttribute('id'),
            'title' => $this->getAttribute('title'),
            'price' => $this->price,
            'attributes' => $additionalAttrs
        ];

        if (!empty($this->offer)) {
            $attrs['price'] = $this->offer['price'];
        }

        return $attrs;
    }

    public static function productsOnShopIndex()
    {
        return ShopProduct::query()->where([
            ['active', 1],
            ['show_on_shop_index_page', 1]
        ])->orderBy('sort')->latest()->paginate(12);
    }

    public function attributesForEdit(): ?array
    {
        foreach ($this->attributesValue->groupBy('attribute_id') as $attributeGroup) {
            $attributeArray = [];
            foreach ($attributeGroup as $attribute) {
                if ($attributeGroup->count() > 1) {
                    $attributeArray['value'][] = $attribute->value;
                } else {
                    $attributeArray['value'] = $attribute->value;
                }
                $attributeArray['attribute_id'] = $attribute->attribute_id;
                $attributeArray['name'] = $attribute->attribute->name;
            }
            $result[] = $attributeArray;
        }
        return $result ?? null;
    }

    public function attributes(): array
    {
        $attributes = [];
        if ($this->attributesForEdit()) {
            foreach ($this->attributesForEdit() as $attribute) {
                $attributes[] = [
                    'name' => $attribute['name'],
                    'value' => is_array($attribute['value']) ? implode(',', $attribute['value']) : $attribute['value'],
                ];
            }
        }
        return $attributes;
    }

    public function jsonDataForCartButton(): bool|string
    {
        return json_encode([
            'id' => $this->id,
            'price' => $this->price,
        ]);
    }

    public function createUrl(ShopCategory $category = null): string
    {
        return ($category ? $category->createUrl() : $this->category->createUrl()) . '/product/' . $this->alias;
    }

    public function getSitemapUrl(): string
    {
        return url($this->createUrl());
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }

}
