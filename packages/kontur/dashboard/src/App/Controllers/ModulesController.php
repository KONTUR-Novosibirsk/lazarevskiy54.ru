<?php

namespace Kontur\Dashboard\App\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Facades\Template;
use Kontur\Dashboard\App\Requests\UpdateModules;
use Kontur\Dashboard\App\Resources\ModulesResource;
use Kontur\Dashboard\App\Services\ModulesService;

class ModulesController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Модули');
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Модули');
        return inertia('Modules/Dashboard/Modules/Index', [
            'modules' => ModulesResource::collection(Modules::getAllModules()),
        ]);
    }

    public function update(UpdateModules $request, ModulesService $service): bool
    {
        return $service->saveSettings($request);
    }
}
