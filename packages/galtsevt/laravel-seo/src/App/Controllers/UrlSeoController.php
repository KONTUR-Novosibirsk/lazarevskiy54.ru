<?php

namespace Galtsevt\LaravelSeo\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Models\SeoForUrl;
use Galtsevt\LaravelSeo\App\Requests\UrlSeoStoreRequest;
use Galtsevt\LaravelSeo\App\Requests\UrlSeoUpdateRequest;
use Galtsevt\LaravelSeo\App\Resources\SeoForUrlResource;
use Illuminate\Support\Facades\Request;
use Kontur\Dashboard\App\Facades\Template;

class UrlSeoController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('SEO', route('admin.seo.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('SEO');

        return inertia('Modules/Seo/Index', [
            'urls' => SeoForUrlResource::collection(
                SeoForUrl::query()->sort(Request::only('order_by', 'order_direction'))
                    ->paginate(auth()->user()->per_page)
            ),
        ]);
    }

    public function store(UrlSeoStoreRequest $request): SeoForUrlResource
    {
        $urlSeo = new SeoForUrl($request->validated());
        $urlSeo->save();
        return new SeoForUrlResource($urlSeo);
    }

    public function update(SeoForUrl $urlSeo, UrlSeoUpdateRequest $request): SeoForUrlResource
    {
        $data = $request->validated();
        $urlSeo->update($data);
        return new SeoForUrlResource($urlSeo);
    }

    public function destroy(SeoForUrl $urlSeo): \Illuminate\Http\RedirectResponse
    {
        $urlSeo->delete();
        return redirect()->back();
    }
}
