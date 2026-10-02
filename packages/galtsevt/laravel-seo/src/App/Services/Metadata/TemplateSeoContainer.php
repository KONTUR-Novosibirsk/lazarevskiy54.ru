<?php

namespace Galtsevt\LaravelSeo\App\Services\Metadata;

use Galtsevt\LaravelSeo\App\Models\Seo;

class TemplateSeoContainer
{
    private array $container;

    public function add(TemplateSeo $templateSeo): static
    {
        $this->container[] = $templateSeo;
        return $this;
    }

    public function getAll(): array
    {
        $this->searchTemplateSeo();
        return $this->container;
    }

    private function searchTemplateSeo(): void
    {
        $seoTemplates = Seo::query()->whereNull('model_id')->get();
        foreach ($this->container as $template) {
            $template->setSeo($seoTemplates->where('model_type', $template->getModel())->first());
        }
    }
}
