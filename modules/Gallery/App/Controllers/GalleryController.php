<?php

namespace Modules\Gallery\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Gallery\App\Models\Gallery;

class GalleryController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'gallery', 'Фотогалерея') , route('gallery.index'));
    }

    public function index(): \Illuminate\Http\Response
    {
        Seo::metaData()->setTitle(settings('name', 'gallery', 'Фотогалерея'));

        return response()->view('gallery::index', [
            'galleries' => Gallery::query()->select('id', 'name', 'text', 'alias', 'image_id')
                ->where('active', true)
                ->withCount('images')
                ->orderBy('id', 'DESC')->paginate(settings('per_page', default: 10)),
        ]);
    }

    public function show(string $alias): \Illuminate\Http\Response
    {
        $gallery = Gallery::query()->where('alias', $alias)->firstOrFail();

        Seo::metaData()->setTitle($gallery->name);
        Seo::breadcrumbs()->add($gallery->name, route('gallery.show', $gallery->alias));

        return response()->view('gallery::show', [
            'gallery' => $gallery,
            'galleryImages' => $gallery->images()->paginate(20),
        ]);
    }


}
