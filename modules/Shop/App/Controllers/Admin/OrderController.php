<?php

namespace Modules\Shop\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Shop\App\Models\ShopOrder;
use Modules\Shop\App\Requests\ChangeOrderStatusRequest;
use Modules\Shop\App\Resources\Order\ShopOrderProductResource;
use Modules\Shop\App\Resources\Order\ShopOrderResource;

class OrderController extends \App\Http\Controllers\Controller
{

    public function __construct()
    {
        Seo::breadcrumbs()->add('Заказы', route('admin.shop.order.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Заказы');

        return inertia('Modules/Shop/Order/Index', [
            'orders' => ShopOrderResource::collection(
                ShopOrder::query()->orderBy('id', 'DESC')
                    ->paginate(auth()->user()->per_page)
            ),
        ]);
    }

    public function show(ShopOrder $shopOrder): \Inertia\Response
    {
        Seo::metaData()->setTitle('Заказ №' . $shopOrder->id);
        Seo::breadcrumbs()->add('Заказ №' . $shopOrder->id, route('admin.shop.order.show', $shopOrder->id));

        return inertia('Modules/Shop/Order/Show', [
            'order' => new ShopOrderResource($shopOrder),
            'products' => ShopOrderProductResource::collection($shopOrder->products),
        ]);
    }

    public function changeStatus(ChangeOrderStatusRequest $request, ShopOrder $shopOrder)
    {
        $shopOrder->update($request->validated());
        return new ShopOrderResource($shopOrder);
    }

    public function destroy(ShopOrder $shopOrder): \Illuminate\Http\RedirectResponse
    {
        $shopOrder->delete();
        return redirect()->route('admin.shop.order.index');
    }
}
