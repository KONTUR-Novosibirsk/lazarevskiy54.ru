<?php

namespace Galtsevt\LaravelSeo\App\Services;

use Galtsevt\LaravelSeo\App\Interfaces\SitemapContract;
use Galtsevt\LaravelSeo\App\Models\Seo;

class SitemapGenerator
{
    public function toString(): bool|string
    {
        return $this->make(new Sitemap())->toString();
    }

    public function saveToFile(): bool|string
    {
        return $this->make(new Sitemap())->saveToFile(public_path('sitemap.xml'));
    }

    protected function make(Sitemap $sitemap): Sitemap
    {
        $pages = Seo::query()->where('site_map', 1)->get();
        foreach ($pages as $page) {
            if ($page->relatedModel instanceof SitemapContract) {
                $sitemap->add($page->relatedModel->getSitemapUrl(), $page->relatedModel->getSitemapDate(), $page->priority, $page->changefreq);
            }
        }
        return $sitemap;
    }
}
