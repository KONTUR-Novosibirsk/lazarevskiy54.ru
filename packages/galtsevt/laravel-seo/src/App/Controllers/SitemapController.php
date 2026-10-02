<?php

namespace Galtsevt\LaravelSeo\App\Controllers;

use Galtsevt\LaravelSeo\App\Services\SitemapGenerator;

class SitemapController extends \App\Http\Controllers\Controller
{
    public function index(SitemapGenerator $sitemapGenerator): \Illuminate\Http\Response
    {
        return response($sitemapGenerator->toString(), 200)
            ->header('Content-Type', 'text/xml');
    }
}
