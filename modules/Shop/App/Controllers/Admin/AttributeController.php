<?php

namespace Modules\Shop\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Support\Facades\Request;
use Modules\Shop\App\Models\ShopAttribute;
use Modules\Shop\App\Requests\Attribute\{StoreRequest, UpdateRequest};
use Modules\Shop\App\Resources\ShopAttributeResource;

class AttributeController extends \App\Http\Controllers\Controller
{
    protected $inertiaPath = 'Modules/Shop/Attribute/';

    public function __construct()
    {
        Seo::breadcrumbs()->addList([
            route('admin.shop.index') => settings('name', 'shop', 'Магазин'),
            route('admin.shop.attribute.index') => 'Атрибуты',
        ]);
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Атрибуты');

        return inertia($this->inertiaPath . 'Index', [
            'filters' => Request::all('search', 'type'),
            'attributes' => ShopAttributeResource::collection(
                resource: ShopAttribute::query()
                    ->filter(Request::only('search', 'type'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('id', 'DESC')
                    ->paginate(auth()->user()->per_page)
                    ->withQueryString()
            ),
        ]);
    }

    public function store(StoreRequest $request): ShopAttributeResource
    {
        $shopAttribute = new ShopAttribute($request->validated());
        $shopAttribute->save();
        return new ShopAttributeResource(resource: $shopAttribute);
    }

    public function update(UpdateRequest $request, ShopAttribute $shopAttribute): ShopAttributeResource
    {
        $shopAttribute->update($request->validated());
        return new ShopAttributeResource(resource: $shopAttribute);
    }

    public function destroy(ShopAttribute $shopAttribute): \Illuminate\Http\RedirectResponse
    {
        $shopAttribute->delete();
        return redirect()->back();
    }
}
