<?php

namespace Galtsevt\LaravelSeo\App\Models;

use App\Models\BaseModel;
use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoForUrl extends BaseModel implements SitemapContract
{
    use HasFactory, HasSeo;

    protected $with = ['seo'];

    protected $table = 'url_seo';

    protected $guarded = false;

    public function getSitemapUrl(): string
    {
        return url($this->url);
    }

    public function getSitemapDate(): string
    {
        return $this->updated_at->format('Y-m-d\TH:i:sP');
    }
}
