<?php

namespace Modules\Gallery\App\Models;

use App\Models\BaseModel;
use Database\Factories\GalleryFactory;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends BaseModel implements SitemapContract
{
    use HasFactory, HasSeo;

    protected $fillable = [
        'name',
        'text',
        'active',
        'alias',
        'image_id',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function newFactory(): GalleryFactory
    {
        return GalleryFactory::new();
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasmany(GalleryImage::class, 'gallery_id', 'id')->orderBy('sort');
    }

    public function getSitemapUrl(): string
    {
        return route('gallery.show', $this->alias);
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }
}
