<?php

namespace Modules\Shop\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Modules\Shop\App\Models\{ShopCategory, ShopFilter};
use Modules\Shop\App\Requests\Category\{StoreCategoryRequest, UpdateCategoryRequest};
use Modules\Shop\App\Resources\{ShopCategoryResource, ShopProductResource};
use Modules\Shop\App\Services\{CategoryService, NestedService};
use Modules\Storage\App\Resources\ImageResource;

class CategoryController extends \App\Http\Controllers\Controller
{

    public function __construct()
    {
        Seo::breadcrumbs()->add(
            name: settings('name', 'shop', 'Магазин'),
            url: route('admin.shop.index')
        );
    }

    public function show(ShopCategory $shopCategory, NestedService $nestedService): \Inertia\Response
    {
        Seo::metaData()->setTitle($shopCategory->title);
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        return inertia('Modules/Shop/Index', [
            'categories' => ShopCategoryResource::collection($shopCategory->children()->withCount('descendants')->get()),
            'products' => ShopProductResource::collection(
                $shopCategory->products()
                    ->with('images')
                    ->filter(Request::only('search', 'active'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->paginate(auth()->user()->per_page)->withQueryString()
            ),
            'category' => new ShopCategoryResource($shopCategory),
            'filters' => Request::all('search', 'active'),
            'offers_count' => settings('with_trade_offers', 'shop', false) ? $shopCategory->offers()->count() : 0,
        ]);
    }

    public function create(
        NestedService $nestedService,
        ShopCategory  $shopCategory = null,
    ): \Inertia\Response
    {
        Seo::metaData()->setTitle('Создать категорию');
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        Seo::breadcrumbs()->add(
            name: 'Создать категорию',
            url: route('admin.shop.category.create', $shopCategory->id ?? null)
        );

        return inertia('Modules/Shop/Category/Edit', [
            'parentCategory' => $shopCategory ? new ShopCategoryResource($shopCategory) : null,
            'categories' => ShopCategoryResource::collection(ShopCategory::query()->get()),
            'images' => ImageResource::collection(Image::getFreeImages($category = new ShopCategory(), 'editor')),
            'preview' => ($preview = Image::getFreeImages($category, 'preview')?->first()) ?
                new ImageResource($preview) : null,
            'model' => ShopCategory::class,
            'filters' => ShopFilter::all()->getDataList('id', 'name'),
        ]);
    }

    public function store(
        StoreCategoryRequest $request,
        CategoryService      $categoryService
    ): ShopCategoryResource
    {
        return $categoryService->store($request);
    }

    public function edit(ShopCategory $shopCategory, NestedService $nestedService): \Inertia\Response
    {
        $shopCategory->load('seo');
        Seo::metaData()->setTitle('Изменить ' . $shopCategory->title);
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        Seo::breadcrumbs()->add('Изменить');

        $childrenCategories = $shopCategory->descendants()->pluck('id');
        $childrenCategories[] = $shopCategory->getKey();

        return inertia('Modules/Shop/Category/Edit', [
            'category' => new ShopCategoryResource($shopCategory),
            'images' => ImageResource::collection($shopCategory->getImagesByGroup('editor')),
            'categories' => ShopCategoryResource::collection(
                ShopCategory::query()->whereNotIn('id', $childrenCategories)->get(),
            ),
            'model' => ShopCategory::class,
            'filters' => ShopFilter::all()->getDataList('id', 'name'),
        ]);
    }

    public function update(
        UpdateCategoryRequest $request,
        ShopCategory          $shopCategory,
        CategoryService       $categoryService
    ): ShopCategoryResource
    {
        return $categoryService->update($request, $shopCategory);
    }

    public function destroy(
        ShopCategory    $shopCategory,
        CategoryService $categoryService,
    ): \Illuminate\Http\RedirectResponse
    {
        if ($categoryService->destroy($shopCategory)) {
            return redirect()->route('admin.shop.index');
        }

        return redirect()->back()->with('error', 'Не удалось удалить категорию');
    }

    /**
     * Обновление сортировки категории
     *
     * @param \Illuminate\Http\Request $request
     * @param ShopCategory $category
     * @return JsonResponse
     */
    public function updateSort(\Illuminate\Http\Request $request, ShopCategory $category): JsonResponse
    {
        $category['sort'] = $request->input(key: 'sort');
        $category->save();

        return response()->json(['success' => true]);
    }
}
