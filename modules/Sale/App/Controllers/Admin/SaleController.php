<?php

namespace Modules\Sale\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Request;
use Modules\Sale\App\Models\Sale;
use Modules\Sale\App\Requests\{StoreRequest, UpdateRequest};
use Modules\Sale\App\Resources\SaleResource;
use Modules\Storage\App\Resources\ImageResource;

class SaleController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'sale', 'Акции'), route('admin.sale.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'sale', 'Акции'));

        return inertia('Modules/Sale/Index', [
            'filters' => Request::all('search', 'active'),
            'sale' => SaleResource::collection(
                Sale::query()->filter(Request::only('search', 'active'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('sort')->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)->withQueryString()
            ),
        ]);
    }

    public function show(Sale $sale): \Illuminate\Http\Response
    {
        return response()->view('sale::show', [
            'sale' => $sale,
        ]);
    }

    public function create(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Новая акция');
        Seo::breadcrumbs()->add('Создать', route('admin.page.create'));
        $sale = new Sale();
        return inertia('Modules/Sale/Edit', [
            'model' => get_class($sale),
            'images' => ImageResource::collection(Image::getFreeImages($sale, 'editor')),
            'preview' => ($preview = Image::getFreeImages($sale, 'preview')?->first()) ?
                new ImageResource($preview) : null
        ]);
    }

    public function store(StoreRequest $request): SaleResource
    {
        $sale = new Sale($request->validated());
        return new SaleResource(tap($sale, fn($sale) => $sale->save()));
    }

    public function edit(Sale $sale): \Inertia\Response
    {
        Seo::metaData()->setTitle('Изменить ' . $sale->title);
        Seo::breadcrumbs()->add($sale->title);
        Seo::breadcrumbs()->add('Изменить', route('admin.sale.edit', $sale->id));
        return inertia('Modules/Sale/Edit', [
            'sale' => new SaleResource($sale),
            'model' => get_class($sale),
            'images' => ImageResource::collection($sale->getImagesByGroup('editor')),
        ]);
    }

    public function update(UpdateRequest $request, Sale $sale): SaleResource
    {
        $sale->update($request->validated());
        return new SaleResource($sale);
    }

    public function destroy(Sale $sale): \Illuminate\Http\RedirectResponse
    {
        $sale->delete();
        return redirect()->route('admin.sale.index');
    }

    /**
     * Обновление сортировки акции
     *
     * @param \Illuminate\Http\Request $request
     * @param Sale $sale
     * @return JsonResponse
     */
    public function updateSort(\Illuminate\Http\Request $request, Sale $sale): JsonResponse
    {
        $sale['sort'] = $request->input(key: 'sort');
        $sale->save();

        return response()->json(['success' => true]);
    }

    /**
     * Получение записей согласно заданной сортировки
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getSaleSort(\Illuminate\Http\Request $request): JsonResponse
    {
        $sort = $request->input(key: 'sort');
        $page = $request->input('page', 1);
        $perPage = auth()->user()->per_page ?? 10;

        $query = Sale::query()
            ->filter(Request::only('search', 'active'))
            ->sort(Request::only('order_by', 'order_direction'))
            ->orderBy('sort', $sort)
            ->orderBy('id', $sort);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $sales = SaleResource::collection(
            $query->paginate($perPage)->withQueryString()
        );

        return response()->json(['sales' => $sales]);
    }
}
