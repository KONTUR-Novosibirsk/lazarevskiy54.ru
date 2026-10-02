<?php

namespace Modules\Shop\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Shop\App\Models\ShopProduct;

class HitProducts extends Component
{

    protected string $limit;

    /**
     * Create a new component instance.
     */
    public function __construct(int $limit = 10)
    {
        $this->limit = $limit;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $products = ShopProduct::query()
            ->where([
                ['hit', 1],
                ['active', 1]
            ])
            ->with([
                'category',
                'images',
            ])
            ->orderBy('sort')
            ->limit($this->limit)->get();

        return view('shop::components.hit-products', [
            'products' => $products,
        ]);
    }
}
