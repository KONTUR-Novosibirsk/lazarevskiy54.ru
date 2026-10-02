<?php

namespace Modules\Menu\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\Menu\App\Menu\NestedMenu;
use Modules\Menu\App\Models\MenuCategory;

class BaseMenuComponent extends Component
{

    protected string $code;
    protected string $parentCss;
    protected string $cachedId = 'BaseMenuComponent';

    /**
     * Create a new component instance.
     */
    public function __construct(string $code, string $parentCss = 'menu')
    {
        $this->code = $code;
        $this->parentCss = $parentCss;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!$menu = Cache::get($this->cachedId . $this->code)) {
            $menu = MenuCategory::query()->with('menuItems')->where('code', $this->code)->first();
            Cache::put($this->cachedId . $this->code, $menu, 2000);
        }

        $nestedMenu = new NestedMenu($menu?->menuItems?->toTree());

        return view('menu::components.base-menu-component', [
            'items' => $nestedMenu->prepareTree(),
            'parentCss' => $this->parentCss,
        ]);
    }
}
