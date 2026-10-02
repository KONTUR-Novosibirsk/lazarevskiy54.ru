<?php

namespace Modules\Shop\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Shop\App\Models\ShopAttribute;
use Modules\Shop\App\Models\ShopFilter;
use Modules\Shop\App\Requests\Filter\StoreRequest;
use Modules\Shop\App\Requests\Filter\UpdateRequest;
use Modules\Shop\App\Resources\Filter\ShopFilterResource;
use Modules\Shop\App\Resources\ShopAttributeResource;
use Modules\Shop\App\Services\FilterService;

class FilterController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Фильтры', route('admin.shop.filter.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Фильтры');

        return inertia('Modules/Shop/Filter/Index', [
            'filters' => ShopFilterResource::collection(
                ShopFilter::query()->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)
            ),
        ]);
    }

    public function create(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Добавить новый фильтр');
        Seo::breadcrumbs()->add('Создать');

        return inertia('Modules/Shop/Filter/Form', [
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->orderBy('id', 'DESC')->get()
            ),
        ]);
    }

    public function store(StoreRequest $request, FilterService $filterService): ShopFilterResource
    {
        $data = $request->validated();
        return new ShopFilterResource($filterService->store($data));
    }

    public function edit(ShopFilter $shopFilter): \Inertia\Response
    {
        Seo::metaData()->setTitle('Изменить ' . $shopFilter->name);
        Seo::breadcrumbs()->add($shopFilter->name);
        Seo::breadcrumbs()->add('Изменить');

        $shopFilter->load('shopAttributes');

        return inertia('Modules/Shop/Filter/Form', [
            'filterData' => new ShopFilterResource($shopFilter),
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->orderBy('id', 'DESC')->get()
            ),
        ]);
    }

    public function update(UpdateRequest $request, ShopFilter $shopFilter, FilterService $filterService): ShopFilterResource
    {
        $data = $request->validated();
        return new ShopFilterResource($filterService->update($data, $shopFilter));
    }

    public function destroy(ShopFilter $shopFilter): \Illuminate\Http\RedirectResponse
    {
        $shopFilter->delete();
        return redirect()->route('admin.shop.filter.index');
    }
}
