<?php

namespace Galtsevt\LaravelSeo\App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Galtsevt\LaravelSeo\App\Services\Breadcrumbs\BreadcrumbsContainer breadcrumbs()
 * @method static \Galtsevt\LaravelSeo\App\Services\Metadata\MetaData metaData()
 * @method static \Galtsevt\LaravelSeo\App\Services\Metadata\TemplateSeoContainer template()
 *
 * @see \Galtsevt\LaravelSeo\App\Services\SeoTools
 *
 **/

class Seo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'app.seo.tools';
    }
}
