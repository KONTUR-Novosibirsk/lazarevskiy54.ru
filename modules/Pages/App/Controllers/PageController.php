<?php

namespace Modules\Pages\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Pages\App\Models\Page;

class PageController extends \App\Http\Controllers\Controller
{
    public function show(Page $page): \Illuminate\Http\Response
    {
        if (!$page->isActive()) {
            abort(404);
        }

        Seo::breadcrumbs()->add($page->title);
        Seo::metaData()->prepare($page)->setTitle($page->title);

        return response()->view($page->template && view()->exists('pages.' . $page->template) ? 'pages.' . $page->template : 'pages.default', [
            'page' => $page,
        ]);
    }
}
