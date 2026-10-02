<?php

namespace Modules\Shop\App\Menu;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Menu\App\Interfaces\BranchContract;
use Modules\Menu\App\Models\MenuItem;
use Modules\Shop\App\Models\ShopCategory;

class NestedCategory implements BranchContract
{

    protected int $maxLevel = 1;
    protected string $cacheId = 'menu_shop_categories';

    public function toTree(): ?array
    {
        if (!$tree = Cache::get($this->cacheId)) {
            $categories = ShopCategory::query()->orderBy('sort')->get()->toTree();
            $tree = $this->prepareTree($categories, 1);
            Cache::put($this->cacheId, $tree);
        }
        return $tree;
    }

    public function setMaxLevel(int $level): static
    {
        $this->maxLevel = $level;
        return $this;
    }

    protected function prepareTree($categories, $level): ?array
    {
        if ($level > $this->maxLevel) return null;

        $level++;

        $menuItems = [];
        foreach ($categories as $category) {
            $menuItem = new MenuItem([
                'name' => $category->title,
                'url' => $category->createUrl(),
            ]);
            if ($category->children && $tree = $this->prepareTree($category->children, $level)) {
                $menuItem->children->addItems($tree);
            }
            $menuItems[] = $menuItem;
        }
        return $menuItems;
    }

}
