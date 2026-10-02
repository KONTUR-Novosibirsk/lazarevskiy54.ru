<?php

namespace Modules\Shop\App\Services;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Shop\App\Models\ShopCategory;

class NestedService
{
    public function createChainOfBreadcrumbs(?ShopCategory $shopCategory): void
    {
        if ($shopCategory) {
            foreach ($shopCategory->ancestors->reverse() as $category) {
                Seo::breadcrumbs()->add($category->title, route('admin.shop.category.show', $category->id));
            }
            Seo::breadcrumbs()->add($shopCategory->title, route('admin.shop.category.show', $shopCategory->id));
        }
    }

    public function createPublicChainOfBreadcrumbs(?ShopCategory $shopCategory): void
    {
        if ($shopCategory) {
            foreach ($shopCategory->ancestors->reverse() as $category) {
                Seo::breadcrumbs()->add($category->title, $category->createUrl());
            }
            Seo::breadcrumbs()->add($shopCategory->title, $shopCategory->createUrl());
        }
    }
}
