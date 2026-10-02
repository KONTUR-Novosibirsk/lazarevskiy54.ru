<?php

namespace Modules\Services\App\Http\Public\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\Response;
use Modules\Services\App\Models\Service;
use Modules\Services\App\Services\ServiceService;

final class ServiceController extends Controller
{
    private string $moduleName;

    public function __construct(private readonly ServiceService $service)
    {
        $this->moduleName = settings('name', 'services', 'Услуги');
    }

    public function index(): Response
    {
        Seo::metaData()->setTitle($this->moduleName);
        Seo::breadcrumbs()->add($this->moduleName, route('services.index'));

        $template = 'services::pages.index.' .
            settings('index_template', 'services', 'list');

        return response()->view($template, [
            'services' => $this->service->getChildren(),
        ]);
    }

    public function show(string $path): Response
    {
        $service = $this->resolveFromPath($path);

        Seo::metaData()->prepare($service)->setTitle($service->name);
        Seo::breadcrumbs()->add($this->moduleName, route('services.index'));
        $this->setBreadcrumbs($service);

        $template = 'services::pages.show.' . settings('show_template', 'services', 'minimal');

        return response()->view($template, [
            'service'  => $service,
            'children' => $this->service->getChildren($service)
        ]);
    }

    private function resolveFromPath(string $path): Service
    {
        $segments = array_values(array_filter(explode('/', $path)));
        $service = $this->service->getByAlias(array_pop($segments));
        $expectedAncestors = $service->ancestors->pluck('alias')->toArray();

        if ($segments !== array_values($expectedAncestors)) {
            abort(404);
        }

        return $service;
    }

    private function setBreadcrumbs(Service $service): void
    {
        foreach ($service->ancestors as $ancestor) {
            Seo::breadcrumbs()->add($ancestor->name, $ancestor->getUrl());
        }
        Seo::breadcrumbs()->add($service->name, $service->getUrl());
    }
}
