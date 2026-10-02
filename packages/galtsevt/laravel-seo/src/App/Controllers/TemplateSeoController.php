<?php

namespace Galtsevt\LaravelSeo\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Requests\UpdateTemplateSeoRequest;
use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Galtsevt\LaravelSeo\App\Resources\TemplateSeoResource;
use Kontur\Dashboard\App\Facades\Template;

class TemplateSeoController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->addList([
            route('admin.seo.index') => 'SEO',
            route('admin.seo.template.index') => 'Шаблонные SEO теги',
        ]);
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Шаблонные SEO теги');

        return inertia('Modules/Seo/Template/Index', [
            'templates' => TemplateSeoResource::collection(Seo::template()->getAll()),
        ]);
    }

    public function updateOrCreate(UpdateTemplateSeoRequest $request): SeoResource
    {
        $data = $request->validated();
        $seo = $data['seo'];
        unset($data['seo']);
        $seo = \Galtsevt\LaravelSeo\App\Models\Seo::query()->updateOrCreate([
            'model_type' => $data['model_type'],
        ], array_merge($data, $seo));

        return new SeoResource($seo);
    }

    public function destroy(\Galtsevt\LaravelSeo\App\Models\Seo $seo): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if ($seo->delete()) {
            return response(true, 200);
        }
        return response(false, 422);
    }
}
