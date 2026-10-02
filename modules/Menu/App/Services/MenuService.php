<?php

namespace Modules\Menu\App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Modules\Menu\App\Models\MenuCategory;
use Modules\Menu\App\Models\MenuItem;
use Modules\Menu\App\Requests\UpdateMenuItemsRequest;
use Modules\Menu\App\Resources\MenuItemResource;

class MenuService
{
    private MenuCategory $menuCategory;

    /**
     * @param UpdateMenuItemsRequest $request
     * @param MenuCategory $menuCategory
     * @return AnonymousResourceCollection
     */
    public function updateMenuItemsInCategory(
        UpdateMenuItemsRequest $request,
        MenuCategory           $menuCategory
    ): AnonymousResourceCollection
    {
        $data = $request->validated();
        $this->menuCategory = $menuCategory;
        Cache::forget('BaseMenuComponent' . $menuCategory->code);
        // рекурсивно перебираем и сохраняем дерево меню
        $this->recursiveUpdateOrCreateTree($data['menuItems'], $menuCategory->menuItems()->get());
        MenuItem::fixTree();
        return MenuItemResource::collection($menuCategory->menuItems()->orderBy('sort')->get()->toTree());
    }

    /**
     * @param array $data
     * @param Collection $menuItems
     * @param null $parentMenuItem
     * @return void
     */
    public function recursiveUpdateOrCreateTree(array $data, Collection $menuItems, $parentMenuItem = null): void
    {
        $sort = 1;
        foreach ($data as $item) {
            $menuItem = $menuItems->where('id', $item['id'])->first();
            // если нет пункта меню в базе, то создаем его
            if (!$menuItem) {
                $menuItem = new MenuItem($item);
                $menuItem->category_id = $this->menuCategory->id;
                $menuItem->save();
            }
            if ($parentMenuItem) { // если есть родитель, закрепляем за ним
                $menuItem->parent_id = $parentMenuItem->id;
            } else {  // иначе root
                $menuItem->parent_id = 0;
            }
            $menuItem->is_branched = $item['is_branched'];
            $menuItem->sort = $sort;  // сортировка соседних элементов
            $menuItem->save();
            $this->recursiveUpdateOrCreateTree($item['children'], $menuItems, $menuItem);
            $sort++;
        }

    }

}
