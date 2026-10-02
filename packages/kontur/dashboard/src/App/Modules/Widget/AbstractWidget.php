<?php

namespace Kontur\Dashboard\App\Modules\Widget;

use Kontur\Dashboard\App\Services\ConfigManager;

abstract class AbstractWidget
{
    protected ?array $config = null;

    protected array $defaultConfig = [
        'active' => false,
        'sort' => 100,
        'size' => 4,
    ];

    abstract public function getId(): string;

    abstract public function getName(): string;

    abstract public function getData(): array;

    abstract public function getDescription(): string;

    public function isActive(): bool
    {
        $config = $this->getConfig();
        return $config['active'];
    }

    public function getSort(): int
    {
        $config = $this->getConfig();
        return $config['sort'];
    }

    public function getSize(): int
    {
        $config = $this->getConfig();
        return $config['size'];
    }

    protected function prepareConfig(): void
    {
        $configManager = new ConfigManager();
        $config = $configManager->find('widgets');
        if (isset($config['widgets'][$this->getId()])) {
            $this->config = $config['widgets'][$this->getId()];
        } else {
            $this->config = $this->defaultConfig;
        }
    }

    protected function getConfig(): array
    {
        if (!$this->config) {
            $this->prepareConfig();
        }
        return $this->config;
    }
}
