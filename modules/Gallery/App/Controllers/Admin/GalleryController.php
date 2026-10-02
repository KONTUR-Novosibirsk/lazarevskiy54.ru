<?php

namespace Modules\Gallery\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Support\Facades\Request;
use Modules\Gallery\App\Models\Gallery;
use Modules\Gallery\App\Requests\Gallery\StoreRequest;
use Modules\Gallery\App\Requests\Gallery\UpdateCoverRequest;
use Modules\Gallery\App\Requests\Gallery\UpdateRequest;
use Modules\Gallery\App\Resources\GalleryResource;
use Modules\Gallery\App\Services\GalleryService;

class GalleryController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'gallery', 'Фотогалерея'), route('admin.gallery.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'gallery', 'Фотогалерея'));
        return inertia('Modules/Gallery/Index', [
            'galleries' => GalleryResource::collection(
                Gallery::query()->select('id', 'name', 'text', 'image_id', 'active')
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->withCount('images')
                    ->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)
            ),
        ]);
    }

    public function store(StoreRequest $request): GalleryResource
    {
        $gallery = new Gallery($request->validated());
        $gallery->active = true;
        $gallery->save();
        return new GalleryResource($gallery);
    }

    public function edit(Gallery $gallery): \Inertia\Response
    {
        Seo::metaData()->setTitle($gallery->name);
        Seo::breadcrumbs()->add($gallery->name, route('admin.gallery.edit', $gallery->id));
        $gallery->load('images');
        return inertia('Modules/Gallery/Edit', [
            'gallery' => new GalleryResource($gallery),
        ]);
    }

    public function update(
        Gallery        $gallery,
        UpdateRequest  $request,
        GalleryService $service
    ): GalleryResource
    {
        return $service->update($request, $gallery);
    }

    public function updateCover(
        Gallery            $gallery,
        UpdateCoverRequest $request,
        GalleryService     $service
    ): GalleryResource
    {
        return $service->update($request, $gallery);
    }

    public function destroy(Gallery $gallery): \Illuminate\Http\RedirectResponse
    {
        $gallery->delete();
        return redirect()->back();
    }
}
