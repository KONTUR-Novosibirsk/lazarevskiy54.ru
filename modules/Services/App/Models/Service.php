<?php

namespace Modules\Services\App\Models;

use App\Models\BaseModel;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Models\Image;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;
use Kontur\Dashboard\App\Casts\HtmlPurify;
use Modules\Services\App\Models\Builders\ServiceBuilder;

/**
 * @property int        $id
 * @property int        $parent_id
 * @property string     $name
 * @property string     $alias
 * @property string     $description
 * @property string     $content
 * @property float      $price
 * @property boolean    $is_active
 * @property boolean    $is_featured
 * @property integer    $sort_order
 * @property int        $_lft
 * @property int        $_rgt
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 *
 * @method static ServiceBuilder query()
 * @method ServiceBuilder newQuery()
 */

final class Service extends BaseModel implements Imageable, SitemapContract
{
    use HasImages, HasSeo, NodeTrait;

    protected $fillable = [
        'name',
        'alias',
        'description',
        'content',
        'price',
        'is_active',
        'is_featured',
        'sort_order',
        'parent_id',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'is_featured'   => 'boolean',
        'content'       => HtmlPurify::class,
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    protected static function booted(): void
    {
        self::saved(function (Service $service) {
            if ($service->wasChanged(['alias', 'parent_id'])) {
                Cache::forget("service_url_{$service->id}");
                $service->descendants()->pluck('id')->each(fn ($id) => Cache::forget("service_url_{$id}"));
            }
            Cache::forget("menu_services");
        });

        self::deleted(function (Service $service) {
            Cache::forget("service_url_{$service->id}");
            $service->descendants()->pluck('id')->each(fn ($id) => Cache::forget("service_url_{$id}"));
            Cache::forget("menu_services");
        });
    }

    public function newEloquentBuilder($query): ServiceBuilder
    {
        return new ServiceBuilder($query);
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->active();
    }

    public function preview(): ?Image
    {
        /** @var Image $image */
        $image = $this->getImagesByGroup('preview')->first();

        return $image;
    }

    public function getUrl(): string
    {
        return Cache::rememberForever("service_url_{$this->id}", function () {
            $path = implode('/', $this->ancestors->pluck('alias')->push($this->alias)->toArray());
            return route('services.index') . '/' . $path;
        });
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ],
        ];
    }

    public function getSitemapUrl(): string
    {
        return url($this->getUrl());
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }
}
