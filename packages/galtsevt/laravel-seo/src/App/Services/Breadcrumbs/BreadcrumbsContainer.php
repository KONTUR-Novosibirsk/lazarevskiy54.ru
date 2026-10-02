<?php

namespace Galtsevt\LaravelSeo\App\Services\Breadcrumbs;

class BreadcrumbsContainer
{
    protected array $breadcrumbs = [];

    public function add(string $name, string $url = null): void
    {
        $this->breadcrumbs[] = new Breadcrumb($name, $url);
    }

    public function addList(array $items): void
    {
        foreach ($items as $url => $name) {
            $this->add($name, $url);
        }
    }

    public function getAll(): array
    {
        return $this->breadcrumbs;
    }
}
