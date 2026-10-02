<?php

namespace Galtsevt\LaravelSeo\App\Traits;

use Galtsevt\LaravelSeo\App\Models\Seo;
use Galtsevt\LaravelSeo\App\Services\SeoService;
use Illuminate\Database\Eloquent\Model;

trait HasSeo
{
    public function seo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function loadSeoFromRequest(): void
    {
        $seoService = new SeoService();
        $seoService->saveData($this);
    }

    protected static function bootHasSeo(): void
    {
        static::saved(function (Model $model) {
            $model->loadSeoFromRequest();
        });
        static::deleting(function (Model $model) {
            $model->seo()->delete();
        });
    }
}
