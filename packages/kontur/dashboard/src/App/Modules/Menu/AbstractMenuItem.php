<?php

namespace Kontur\Dashboard\App\Modules\Menu;

abstract class AbstractMenuItem
{
    public function __construct(
        protected string  $name,
        protected ?string $routeName = null,
        protected ?string $icon = null,
        protected ?array  $menuItems = null,
    )
    {

    }

    public function hasMenuItems(): bool
    {
        return $this->menuItems !== null;
    }

    public function getMenuItems(): ?array
    {
        return $this->menuItems;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRouteName(): string
    {
        return $this->routeName;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

}
