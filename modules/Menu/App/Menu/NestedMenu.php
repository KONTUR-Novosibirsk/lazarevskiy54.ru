<?php

namespace Modules\Menu\App\Menu;

use Illuminate\Support\Collection;
use Modules\Menu\App\Interfaces\BranchContract;

class NestedMenu
{

    public function __construct(
        protected ?Collection $menu,
    )
    {

    }

    public function prepareTree(): Collection
    {
        if (!$this->menu) return collect();
        $this->prepareNested($this->menu);

        return $this->menu;
    }

    protected function prepareNested($nestedMenu): void
    {
        foreach ($nestedMenu as $menu) {

            if ($menu->children->count() > 0) {
                $this->prepareNested($menu->children);
            }

            if ($menu->is_branched && $menu->branch_class && class_exists($menu->branch_class)) {
                $branchClass = new $menu->branch_class();
                if ($branchClass instanceof BranchContract && $tree = $branchClass->toTree()) {
                    $menu->children->addItems($tree);
                }
            }
        }
    }
}
