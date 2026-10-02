<?php

namespace Modules\News\App\Models;

use App\Models\BaseModel;
use Database\Factories\NewsFactory;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Interfaces\Fileable;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasFiles;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Kontur\Dashboard\App\Traits\HasShortText;


class News extends BaseModel implements Imageable, Fileable, SitemapContract
{
    use HasFactory, HasImages, HasSeo, HasShortText, HasFiles;

    protected $guarded = false;

    protected $casts = [
        'active' => 'boolean',
        'publication_date' => 'datetime',
    ];

    protected static function newFactory(): NewsFactory
    {
        return NewsFactory::new();
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ],
        ];
    }

    public function getPublicationDate(): ?string
    {
        return $this->publication_date ? $this->publication_date->format('Y-m-d\TH:i') : null;
    }

    public function getPublicationDateForHuman(): ?string
    {
        return $this->publication_date ? $this->publication_date->isoFormat('LLL') : null;
    }

    public function getTitle(): string
    {
        return !$this->title ? 'Черновик id:' . $this->id : $this->title;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function getUrl(): string
    {
        return route('news.show', $this->alias);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where([
            ['publication_date', '<=', Carbon::now()],
            ['active', '=', 1],
        ]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->when(isset($filters['active']) && in_array($filters['active'], [0, 1]), function ($query, $active) use ($filters) {
            $query->where('active', '=', $filters['active']);
        });
    }

    public function getSitemapUrl(): string
    {
        return route('news.show', $this->alias);
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }
}
