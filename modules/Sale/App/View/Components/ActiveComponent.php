<?php

namespace Modules\Sale\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Sale\App\Models\Sale;

class ActiveComponent extends Component
{
    protected int $limit;

    /**
     * Create a new component instance.
     */
    public function __construct(int $limit = 5)
    {
        $this->limit = $limit;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('sale::components.active-component', [
            'items' => Sale::query()->active()->with('images')->orderBy('id', 'DESC')->limit($this->limit)->get(),
        ]);
    }
}
