<?php

namespace Modules\Services\App\Menu;

use Illuminate\Support\Facades\Cache;
use Modules\Menu\App\Interfaces\BranchContract;
use Modules\Menu\App\Models\MenuItem;
use Modules\Services\App\Models\Service;

final class NestedService implements BranchContract
{
    protected int $maxLevel = 1;
    protected string $cacheId = 'menu_services';

    public function toTree(): ?array
    {
        if (!$tree = Cache::get($this->cacheId)) {
            $services = Service::query()
                ->active()
                ->sortBy('created_at', 'desc')
                ->get()
                ->toTree();
            $tree = $this->prepareTree($services, 1);
            Cache::put($this->cacheId, $tree);
        }
        return $tree;
    }

    public function setMaxLevel(int $level): static
    {
        $this->maxLevel = $level;
        return $this;
    }

    protected function prepareTree($services, $level): ?array
    {
        if ($level > $this->maxLevel) return null;

        $level++;

        $menuItems = [];
        foreach ($services as $service) {
            $menuItem = new MenuItem([
                'name' => $service->name,
                'url' => $service->getUrl(),
            ]);
            if ($service->children && $tree = $this->prepareTree($service->children, $level)) {
                $menuItem->children->addItems($tree);
            }
            $menuItems[] = $menuItem;
        }
        return $menuItems;
    }

}
