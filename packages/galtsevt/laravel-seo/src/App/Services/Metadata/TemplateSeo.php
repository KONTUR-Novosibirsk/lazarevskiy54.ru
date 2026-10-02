<?php

namespace Galtsevt\LaravelSeo\App\Services\Metadata;

use Galtsevt\LaravelSeo\App\Models\Seo;

class TemplateSeo
{
    private string $name;

    private string $model;

    private ?Seo $seo;

    public function __construct(string $name, string $model)
    {
        $this->name = $name;
        $this->model = $model;
    }

    public function setSeo(?Seo $seo): void
    {
        $this->seo = $seo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return Seo
     */
    public function getSeo(): ?Seo
    {
        return $this->seo;
    }

}
