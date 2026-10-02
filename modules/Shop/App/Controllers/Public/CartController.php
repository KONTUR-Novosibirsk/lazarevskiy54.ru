<?php

namespace Modules\Shop\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Modules\Shop\App\Models\ShopProduct;
use Modules\Shop\App\Requests\AddToCartRequest;
use Modules\Shop\App\Requests\RemoveFromCart;
use Modules\Shop\App\Resources\Cart\ShopProductResource;
use Modules\Shop\App\Services\Cart;

class CartController extends \App\Http\Controllers\Controller
{
    public function index(Cart $cart)
    {
        Seo::breadcrumbs()->add('Корзина');
        Seo::metaData()->setTitle('Корзина');

        $cartData = $cart->getItemsFromDb();
        $cartData['products'] = ShopProductResource::collection($cartData['products']);
        return response()->view('shop::cart.index', $cartData);
    }

    public function addProduct(
        AddToCartRequest $request,
        Cart             $cart
    ): bool|array
    {
        $data = $request->validated();

        $product = ShopProduct::query()->where([
            ['active', 1],
            ['price', '>', 0],
        ])->findOrFail($data['id']);
        $product->attrs = array_key_exists('attributes', $data) ? $data['attributes'] : null;
        $product->offer = array_key_exists('offer', $data) ? $data['offer'] : null;;
        return [
            'product' => $cart->add($product, $data['count']),
            'cart_total_count' => $cart->count(),
        ];
    }

    public function remove(
        RemoveFromCart $request,
        Cart           $cart,
    ): bool|array
    {
        $data = $request->validated();

        return $cart->remove($data['hash'], $data['count']);
    }

    public function flush(
        Cart $cart
    ): RedirectResponse
    {
        $cart->flush();

        return Redirect::back();
    }
}
