<?php

namespace Modules\Shop\App\Controllers\Public;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\Request;
use Modules\Shop\App\Contracts\ProductFilterContract;
use Modules\Shop\App\Filters\ProductFilter;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Services\NestedService;
use Modules\Shop\App\Services\Public\CategoryService;

class CategoryController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'shop', 'Магазин'), route('shop.index'));
    }

    public function categoryPath(
        Request               $request,
        ShopCategory          $category,
        NestedService         $nestedService,
        ProductFilterContract $productFilter,
        CategoryService       $categoryService,
    )
    {
        $uri = $request->getPathInfo();

        if (!$category->checkPathValid($uri) || !($category = $category->getByAliasFromUri($uri)))
            abort(404);

        $nestedService->createPublicChainOfBreadcrumbs($category);
        Seo::metaData()->prepare($category)->setTitle($category->title);

        return $categoryService->productsOrTradeOffers($category, $productFilter);
    }

    public function category(ShopCategory $category)
    {
        return view('shop::category', [
            'category' => $category,
        ]);
    }

}
