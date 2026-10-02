<?php

namespace Kontur\Dashboard\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Kontur\Dashboard\App\Requests\UpdateWidgets;
use Kontur\Dashboard\App\Resources\WidgetResource;
use Kontur\Dashboard\App\Services\WidgetService;

class WidgetController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Виджеты');

    }

    public function index(WidgetService $widgetService): \Inertia\Response
    {
        Seo::metaData()->setTitle('Виджеты');
        return inertia('Modules/Dashboard/Widget/Index', [
            'widgets' => WidgetResource::collection($widgetService->getSortedWidget()),
        ]);
    }

    public function update(
        UpdateWidgets $request,
        WidgetService $widgetService
    ): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $widgetService->update($request);
    }

}
