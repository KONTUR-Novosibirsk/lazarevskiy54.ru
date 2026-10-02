<?php

namespace Kontur\Dashboard\App\Modules;

use Illuminate\Support\Facades\Cache;
use Kontur\Dashboard\App\Services\ConfigManager;

class ModulesContainer
{
    protected array $container;
    protected ?array $config;

    public function __construct(
        private readonly ConfigManager $configManager = new ConfigManager(),
    )
    {
        $this->prepareConfig();
    }

    public function register(AbstractModule $module): AbstractModule
    {
        $this->container[$module->getId()] = $module;
        return $module;
    }

    public function get(string $moduleName): ?AbstractModule
    {
        if (isset($this->container[$moduleName])) {
            return $this->container[$moduleName];
        }
        return null;
    }

    public function getWidgets(bool $active = false): array
    {
        foreach ($this->getActiveModules() as $module) {
            foreach ($module->getWidgets() as $item) {

                if ($active) {
                    if ($item->isActive()) {
                        $items[] = $item;
                    }
                } else {
                    $items[] = $item;
                }
            }
        }
        return $items ?? [];
    }

    public function getAllModules(): array
    {
        return $this->container;
    }

    public function getActiveModules(): array
    {
        foreach ($this->container as $module) {
            if ($module->isActive()) {
                $result[] = $module;
            }
        }

        return $result ?? [];
    }

    public function getSidebarItems(): array
    {
        foreach ($this->getActiveModules() as $module) {
            foreach ($module->getSidebarItems() as $item) {
                $items[] = $item;
            }
        }

        return $items ?? [];
    }

    public function getHeaderItems(): array
    {
        foreach ($this->getActiveModules() as $module) {
            foreach ($module->getHeaderItems() as $item) {
                $items[] = $item;
            }
        }

        return $items ?? [];
    }

    protected function prepareConfig(): void
    {
        $config = $this->configManager->find('modules');
        if (isset($config['modules'])) {
            $this->config = $config['modules'];
        }
    }

    public function getConfig(string $module, mixed $default): array
    {
        if (isset($this->config[$module])) {
            return $this->config[$module];
        }
        return $default;
    }
}
