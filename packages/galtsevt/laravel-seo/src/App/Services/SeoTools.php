<?php

namespace Galtsevt\LaravelSeo\App\Services;

use Galtsevt\LaravelSeo\App\Services\Breadcrumbs\BreadcrumbsContainer;
use Galtsevt\LaravelSeo\App\Services\Metadata\MetaData;
use Galtsevt\LaravelSeo\App\Services\Metadata\TemplateSeoContainer;

class SeoTools
{
    protected BreadcrumbsContainer $breadcrumbs;
    protected MetaData $metaData;
    protected TemplateSeoContainer $templateSeoContainer;


    public function __construct()
    {
        $this->breadcrumbs = new BreadcrumbsContainer();
        $this->metaData = new MetaData();
        $this->templateSeoContainer = new TemplateSeoContainer();
    }

    public function breadcrumbs(): BreadcrumbsContainer
    {
        return $this->breadcrumbs;
    }

    public function metaData(): MetaData
    {
        return $this->metaData;
    }

    public function template(): TemplateSeoContainer
    {
        return $this->templateSeoContainer;
    }

}
