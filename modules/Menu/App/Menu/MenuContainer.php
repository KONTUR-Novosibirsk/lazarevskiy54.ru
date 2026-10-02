<?php

namespace Modules\Menu\App\Menu;

use Illuminate\Database\Eloquent\Collection;

class MenuContainer
{
    protected string $name;
    protected array $items;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(array $items): static
    {
        foreach ($items as $item) {
            $this->items[] = $item;
        }
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMenuItems(): array
    {
        return $this->items;
    }

    public function deleteExistItems(Collection $menu): static
    {
        $this->items = array_filter($this->items, function ($item) use ($menu) {
            return $menu->filter(function ($collectionItem) use ($item) {
                    return $collectionItem->name == $item->name
                        && $collectionItem->route_name == $item->route_name
                        && $collectionItem->route_attributes == $item->route_attributes
                        && $collectionItem->url == $item->url;
                })->count() === 0;
        });

        return $this;
    }
}
