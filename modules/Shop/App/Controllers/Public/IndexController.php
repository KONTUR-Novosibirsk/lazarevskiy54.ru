<?php

namespace Modules\Shop\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Models\ShopProduct;

class IndexController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'shop', 'Магазин'), route('shop.index'));
    }

    public function index()
    {
        Seo::metaData()->setTitle(settings('name', 'shop', 'Магазин'));

        return view('shop::index', [
            'categories' => ShopCategory::query()
                ->where('parent_id', null)
                ->orderBy('sort')
                ->get(),
            'products' => ShopProduct::productsOnShopIndex(),
        ]);
    }
}
