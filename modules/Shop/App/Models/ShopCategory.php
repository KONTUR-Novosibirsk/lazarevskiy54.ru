<?php

namespace Modules\Shop\App\Models;

use App\Models\BaseModel;
use Database\Factories\ShopCategoryFactory;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Shop\App\Traits\AliasHelperTrait;

class ShopCategory extends BaseModel implements Imageable, SitemapContract
{
    use HasFactory, HasImages, NodeTrait, HasSeo, AliasHelperTrait;

    protected $fillable = [
        'title',
        'alias',
        'show_on_index_page',
        'description',
        'filter_id',
        'sort'
    ];

    protected $casts = [
        'show_on_index_page' => 'boolean',
    ];

    protected static function newFactory(): ShopCategoryFactory
    {
        return ShopCategoryFactory::new();
    }

    public function getStopWord()
    {
        return 'product';
    }

    public function getStartWord()
    {
        return 'shop';
    }

    public function getDepth()
    {
        return $this::withDepth()->where('id', $this->id)->first()?->depth;
    }

    public static function getCategoriesByDepth($depth)
    {
        return self::withDepth()->having('depth', '=', $depth)->get();
    }

    private function getCacheId(): string
    {
        return 'route_category_' . $this->id;
    }

    public function createUrl(): string
    {
        if (!$uri = Cache::get($this->getCacheId())) {

            $uri[] = $this->getStartWord();

            foreach ($this->ancestors()->orderBy('id', 'ASC')->get() as $parent) {
                $uri[] = $parent->alias;
            }

            $uri[] = $this->alias;

            $uri = implode('/', $uri);

            Cache::set($this->getCacheId(), $uri, 84600);
        };

        return '/' . $uri;
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopProduct::class, 'category_id', 'id');//->orderBy('sort');
    }

    public function offers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopTradeOffer::class, 'category_id', 'id');
    }

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function nestedProductsCount(): int
    {
        $categories = $this->descendants()->pluck('id');
        $categories[] = $this->getKey();
        return ShopProduct::query()->whereIn('category_id', $categories)->count();
    }

    public static function getByAliasFromUri($uri)
    {
        preg_match("/^\/shop\/(.*)\/product\/[-a-zA-Z0-9+_]+$/", $uri, $matches);

        if (count($matches) == 0) {
            preg_match("/^\/shop\/(.*)/", $uri, $matches);
        }
        preg_match("/[^\/]+$/", $matches[1], $alias);

        return static::query()->where('alias', $alias[0])->first();
    }

    public function filter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopFilter::class, 'filter_id', 'id')->with('shopAttributes');
    }

    public function getFilterableAttributes(): ?\Illuminate\Support\Collection
    {
        if (!$this->filter?->shopAttributes)
            return null;
        $filterAttributes = $this->filter->shopAttributes->pluck('attribute_id');

        $attributeValues = ShopAttributeValue::query()->with('attribute')
            ->whereIn('attribute_id', $filterAttributes)
            ->whereRelation('product', 'category_id', $this->id)
            ->get()->unique('value');

        foreach ($this->filter?->shopAttributes as $attribute) {
            $attribute->data = [];
            foreach ($attributeValues->where('attribute_id', $attribute->attribute_id) as $attributeValue) {
                $attribute->data = array_merge([
                    [
                        'key' => $attributeValue['value'],
                        'value' => $attributeValue['value'],
                    ]
                ], $attribute->data);
            }
        }
        return $this->filter?->shopAttributes;
    }

    protected static function booted(): void
    {
        static::saved(function (ShopCategory $shopCategory) {
            foreach ($shopCategory->descendants->merge(collect([$shopCategory])) as $category)
                Cache::forget($category->getCacheId());
            Cache::forget('menu_shop_categories');
        });
    }

    public function getSitemapUrl(): string
    {
        return url($this->createUrl());
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ],
        ];
    }
}
