<?php

namespace Modules\Shop\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Modules\Shop\App\Models\{ShopAttribute, ShopCategory, ShopProduct};
use Modules\Shop\App\Requests\Product\{StoreProductRequest, UpdateProductRequest};
use Modules\Shop\App\Resources\{ShopAttributeResource, ShopCategoryResource, ShopProductResource};
use Modules\Shop\App\Services\{NestedService, ProductService};
use Modules\Storage\App\Resources\ImageResource;

class ProductController extends \App\Http\Controllers\Controller
{

    public function __construct()
    {
        Seo::breadcrumbs()->add(
            name: settings('name', 'shop', 'Магазин'),
            url: route('admin.shop.index')
        );
    }

    public function create(
        ShopCategory  $shopCategory,
        NestedService $nestedService,
    ): \Inertia\Response
    {
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        Seo::metaData()->setTitle('Добавление продукта');
        Seo::breadcrumbs()->add('Добавить продукт', route('admin.shop.product.create', $shopCategory->id));
        return inertia('Modules/Shop/Product/Edit', [
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->orderBy('id', 'DESC')->get()
            ),
            'model' => ShopProduct::class,
            'parent_category' => new ShopCategoryResource($shopCategory),
            'categories' => ShopCategoryResource::collection(ShopCategory::query()->get()),
            'images' => ImageResource::collection(Image::getFreeImages(new ShopProduct(), 'editor')),
            'previewImages' => ImageResource::collection(Image::getFreeImages(new ShopProduct(), 'preview')),
        ]);
    }

    public function store(StoreProductRequest $request, ProductService $productService): ShopProductResource
    {

        return $productService->store($request);
    }

    public function edit(ShopProduct $shopProduct, NestedService $nestedService): \Inertia\Response
    {
        $shopProduct->load('seo', 'attributesValue');
        $nestedService->createChainOfBreadcrumbs($shopProduct->category);
        Seo::metaData()->setTitle('Изменение ' . $shopProduct->title);
        Seo::breadcrumbs()->addList([
            $shopProduct->title,
            route('admin.shop.product.update', $shopProduct->id) => 'Изменить',
        ]);

        return inertia('Modules/Shop/Product/Edit', [
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->orderBy('id', 'DESC')->get()
            ),
            'model' => ShopProduct::class,
            'product' => new ShopProductResource($shopProduct),
            'categories' => ShopCategoryResource::collection(ShopCategory::query()->get()),
            'images' => ImageResource::collection($shopProduct->getImagesByGroup('editor')),
            'previewImages' => ImageResource::collection($shopProduct->getImagesByGroup('preview')),
        ]);
    }

    public function update(
        UpdateProductRequest $request,
        ShopProduct          $shopProduct,
        ProductService       $productService,
    ): ShopProductResource
    {
        return $productService->update($request, $shopProduct);
    }

    public function clone(ShopProduct $shopProduct, ProductService $productService): ShopProductResource
    {
        return new ShopProductResource($productService->clone($shopProduct));
    }

    public function destroy(ShopProduct $shopProduct): \Illuminate\Http\RedirectResponse
    {
        $shopProduct->delete();
        return redirect()->back();
    }

    /**
     * Обновление сортировки продукта
     *
     * @param Request $request
     * @param ShopProduct $product
     * @return JsonResponse
     */
    public function updateSort(Request $request, ShopProduct $product): JsonResponse
    {
        $product['sort'] = $request->input(key: 'sort');
        $product->save();

        return response()->json(['success' => true]);
    }

    /**
     * Получение записей согласно заданной сортировки
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getProductsSort(\Illuminate\Http\Request $request): JsonResponse
    {
        $sort = $request->input(key: 'sort');
        $page = $request->input('page', 1);
        $perPage = auth()->user()->per_page ?? 10;
        $category = $request->input('category');

        if ($category) {
            $categoryModel = ShopCategory::query()->find($category['id']);
            $query = $categoryModel->products()
                ->with('images')
                ->filter(\Illuminate\Support\Facades\Request::only('search', 'active'))
                ->sort(\Illuminate\Support\Facades\Request::only('order_by', 'order_direction'))
                ->orderBy('sort', $sort)
                ->orderBy('id', $sort);
        }
        else {
            $query = ShopProduct::query()
                ->with('images')
                ->filter(\Illuminate\Support\Facades\Request::only('search', 'active'))
                ->sort(\Illuminate\Support\Facades\Request::only('order_by', 'order_direction'))
                ->with('images', 'attributesValue')
                ->when(request('search') == 0, function ($query) {
                    return $query->where('show_on_shop_index_page', true);
                })
                ->orderBy('sort', $sort)
                ->orderBy('id', $sort);
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = ShopProductResource::collection(
            $query->paginate($perPage)->withQueryString()
        );

        return response()->json(['products' => $products]);
    }
}
