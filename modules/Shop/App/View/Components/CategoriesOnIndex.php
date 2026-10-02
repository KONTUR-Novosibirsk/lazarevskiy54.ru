<?php

namespace Modules\Shop\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Shop\App\Models\ShopCategory;

class CategoriesOnIndex extends Component
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
        $categories = ShopCategory::query()
            ->where([
                ['show_on_index_page', 1],
            ])
            ->with([
                'images',
            ])
            ->orderBy('sort')
            ->limit($this->limit)->get();

        return view('shop::components.categories-on-index', [
            'categories' => $categories,
        ]);
    }
}
