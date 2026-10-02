<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

abstract class AbstractFormElement
{
    protected string $rules;
    protected string $name;
    protected bool $visible = true;

    protected string $groupName = 'main';

    protected array $config = [];

    /**
     * Модель (для использования изображений)
     *
     * @var string $model
     */
    protected string $model = '';

    public function setGroupName($group): void
    {
        $this->groupName = $group;
    }

    public function getRules(): ?string
    {
        return $this->rules ?? 'nullable|string|max:200';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        $value = settings($this->name, $this->groupName) ?? ($this->config['default'] ?? '');

        if (isset($this->config['type']) && $this->config['type'] == 'checkbox') {
            $value = (bool)$value;
        }

        return $value;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function beforeSave($value): mixed
    {
        return $value;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

}
