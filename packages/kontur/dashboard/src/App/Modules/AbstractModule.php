<?php

namespace Kontur\Dashboard\App\Modules;

use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Header\HeaderItemInterface;
use Kontur\Dashboard\App\Modules\Widget\AbstractWidget;

abstract class AbstractModule
{
    protected string $id;

    protected string $name;

    protected array $sidebarItems;

    protected array $headerItems;

    protected array $widgets;

    protected array $config = [
        'active' => false,
        'withSidebar' => true,
        'withHeader' => true,
        'withWidget' => true,
    ];

    public function __construct(
        string $id,
        string $name,
        array  $sidebarItems = null,
        array  $headerItems = null,
        array  $widgets = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->config = $this->prepareConfig();
        if ($sidebarItems) {
            $this->setSidebarItems($sidebarItems);
        }

        if ($headerItems) {
            $this->setHeaderItems($headerItems);
        }

        if ($widgets) {
            $this->setWidgets($widgets);
        }
    }

    protected function prepareConfig(): array
    {
        return Modules::getConfig($this->id, $this->config);
    }

    public function isActive(): bool
    {
        return $this->config['active'];
    }

    public function setSidebarItems(array $items): void
    {
        foreach ($items as $item) {
            $this->sidebarItems[] = $item;
        }
    }

    public function setHeaderItems(array $items): void
    {
        foreach ($items as $item) {
            if ($item instanceof HeaderItemInterface) {
                $this->headerItems[] = $item;
            }
        }
    }

    public function setWidgets(array $items): void
    {
        foreach ($items as $item) {
            if ($item instanceof AbstractWidget) {
                $this->widgets[] = $item;
            }
        }
    }

    public function getSidebarItems(): array
    {
        if ($this->withSidebar()) {
            return $this->sidebarItems ?? [];
        }
        return [];
    }

    public function getHeaderItems(): ?array
    {
        if ($this->withHeader()) {
            return $this->headerItems ?? [];
        }
        return [];
    }

    public function getWidgets(): ?array
    {
        if ($this->withWidget()) {
            return $this->widgets ?? [];
        }
        return [];
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function withSidebar(): bool
    {
        return $this->config['withSidebar'];
    }

    public function withHeader(): bool
    {
        return $this->config['withHeader'];
    }

    public function withWidget(): bool
    {
        return $this->config['withWidget'];
    }
}
