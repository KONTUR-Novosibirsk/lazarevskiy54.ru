<?php

namespace Modules\Shop\App\Services\Public;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Modules\Shop\App\Models\ShopProduct;

class ProductService
{
    public function setRecentProduct(ShopProduct $shopProduct): void
    {
        if (!($recentProducts = Session::get('recent.products')) instanceof Collection) {
            $recentProducts = collect();
        }

        $recentProducts = $recentProducts->reject(function (int $value, int $key) use ($shopProduct) {
            return $value == $shopProduct->id;
        });
        $recentProducts->add($shopProduct->id);
        Session::put('recent.products', $recentProducts);
    }

    public function getRecentProducts(ShopProduct $shopProduct)
    {
        $sessionProducts = Session::get('recent.products', []);
        return ShopProduct::query()->whereIn('id', $sessionProducts->slice(-10)->reverse())
            ->where('id', '!=', $shopProduct->id)->active()
            ->orderByRaw('FIELD(id, '.implode(", " , $sessionProducts->slice(-10)->reverse()->toArray()).')')
            ->with(['images', 'category'])->orderBy('sort')->get();
    }
}
