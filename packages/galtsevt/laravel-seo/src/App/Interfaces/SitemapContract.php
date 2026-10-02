<?php

namespace Galtsevt\LaravelSeo\App\Interfaces;

interface SitemapContract
{
    public function seo(): \Illuminate\Database\Eloquent\Relations\MorphOne;

    public function getSitemapUrl(): string;

    public function getSitemapDate(): string;
}
