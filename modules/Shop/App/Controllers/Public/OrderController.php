<?php

namespace Modules\Shop\App\Controllers\Public;

use Modules\Shop\App\Models\ShopOrder;
use Modules\Shop\App\Requests\StoreOrderRequest;
use Modules\Shop\App\Services\Cart;

class OrderController extends \App\Http\Controllers\Controller
{
    public function store(Cart $cart, StoreOrderRequest $request): ShopOrder|\Illuminate\Http\RedirectResponse
    {
        $cartData = $cart->getItemsFromDb();
        if ($cartData['products']->count() === 0) {
            return redirect()->route('index');
        }
        $order = new ShopOrder($request->validated());
        $order->price = $cartData['totalPrice'];
        $order->save();

        foreach ($cartData['products'] as $product) {
            $order->products()->attach($product, [
                'price' => $product->price,
                'count' => $product->count,
            ]);
        }
        $order->sendNotifications();
        $cart->flush();

        return $order;
    }
}
