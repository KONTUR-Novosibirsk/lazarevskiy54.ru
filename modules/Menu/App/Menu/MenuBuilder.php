<?php

namespace Modules\Menu\App\Menu;

use Illuminate\Database\Eloquent\Collection;

class MenuBuilder
{
    private array $menuContainers = [];

    public function add(array $menuItems, string $groupName = 'main'): static
    {
        $this->getContainer($groupName)->add($menuItems);
        return $this;
    }

    public function getContainers(): array
    {
        return $this->menuContainers;
    }

    public function deleteExistItems(Collection $items): static
    {
        foreach ($this->menuContainers as $container) {
            $container->deleteExistItems($items);
        }
        return $this;
    }

    protected function getContainer(string $name)
    {

        foreach ($this->menuContainers as $container) {
            if ($container->getName() == $name) return $container;
        }
        $container = new MenuContainer($name);
        $this->menuContainers[] = $container;
        return $container;
    }
}
