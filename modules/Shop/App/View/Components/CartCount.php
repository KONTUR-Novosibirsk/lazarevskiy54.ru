<?php

namespace Modules\Shop\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Shop\App\Services\Cart;

class CartCount extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cart = app(Cart::class);

        return view('shop::components.cart_count', [
            'count' => $cart->count(),
        ]);
    }
}
