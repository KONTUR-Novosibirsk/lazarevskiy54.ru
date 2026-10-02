<?php

namespace Modules\Pages\App\Models;

use App\Models\BaseModel;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Fileable;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasFiles;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\App\Models\MenuItem;

class Page extends BaseModel implements Imageable, Fileable, SitemapContract
{
    use HasFactory, HasSeo, HasImages, HasFiles;

    protected $guarded = false;

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::updated(function (Page $page) {
            $page->menuItems()->update([
                'name' => $page->title,
                'route_attributes' => ['alias' => $page->alias],
            ]);
        });
        static::deleted(function (Page $page) {
            $page->menuItems()->delete();
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function getUrl(): string
    {
        return route('page.show', $this->alias);
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->when(isset($filters['active']) && in_array($filters['active'], [0, 1]), function ($query, $active) use ($filters) {
            $query->where('active', '=', $filters['active']);
        });
    }

    public function menuItems(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(MenuItem::class, 'model');
    }

    public function getSitemapUrl(): string
    {
        return route('page.show', $this->alias);
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }
}
