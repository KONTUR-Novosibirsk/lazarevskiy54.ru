<?php

namespace Kontur\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Kontur\Dashboard\App\Resources\WidgetResource;
use Kontur\Dashboard\App\Services\WidgetService;

class IndexController extends Controller
{
    public function index(WidgetService $widgetService): \Inertia\Response|\Inertia\ResponseFactory
    {
        Seo::metaData()->setTitle('Панель управления');
        Seo::breadcrumbs()->add('Панель управления', route('admin.index'));

        return inertia('Index', [
            'widgets' => WidgetResource::collection($widgetService->getSortedWidget(true)),
        ]);
    }
}
