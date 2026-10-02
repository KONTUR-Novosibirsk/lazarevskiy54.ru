<?php

namespace Modules\Menu\App\Menu;

class Menu
{
    private array $menuContainers;

    public function group($name, array $menuItems): static
    {
        $this->menuContainers[] = $this->getContainer($name)->add($menuItems);
        return $this;
    }

    public function getContainers(): array
    {
        return $this->menuContainers;
    }

    protected function getContainer(string $name)
    {
        foreach ($this->menuContainers as $container) {
            if ($container->getName() == $name) return $container;
        }

        return new MenuContainer($name);
    }
}
