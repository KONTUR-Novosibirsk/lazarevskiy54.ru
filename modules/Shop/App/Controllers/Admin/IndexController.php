<?php

namespace Modules\Shop\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Support\Facades\Request;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Models\ShopProduct;
use Modules\Shop\App\Resources\ShopCategoryResource;
use Modules\Shop\App\Resources\ShopProductResource;

class IndexController extends \App\Http\Controllers\Controller
{
    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'shop', 'Магазин'));
        Seo::breadcrumbs()->add(settings('name', 'shop', 'Магазин'));

        return inertia('Modules/Shop/Index', [
            'categories' => ShopCategoryResource::collection(
                ShopCategory::query()
                    ->with('images')
                    ->whereNull('parent_id')
                    ->withCount('descendants')
                    ->orderBy('sort')
                    ->get()
            ),
            'products' => ShopProductResource::collection(
                ShopProduct::query()
                    ->with('images')
                    ->filter(Request::only('search', 'active'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->with('images', 'attributesValue')
                    ->when(request('search') == 0, function ($query) {
                        return $query->where('show_on_shop_index_page', true);
                    })
                    ->orderBy('sort')
                    ->paginate(auth()->user()->per_page)->withQueryString()
            ),
            'filters' => Request::all('search', 'active'),
        ]);
    }
}
