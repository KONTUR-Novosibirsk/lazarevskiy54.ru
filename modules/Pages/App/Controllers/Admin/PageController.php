<?php

namespace Modules\Pages\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\{File, Image};
use Illuminate\Support\Facades\Request;
use Modules\Pages\App\Models\Page;
use Modules\Pages\App\Requests\{StoreRequest, UpdateRequest};
use Modules\Pages\App\Resources\PageResource;
use Modules\Pages\App\Services\PageService;
use Modules\Storage\App\Resources\{FileResource, ImageResource};

class PageController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Страницы', route('admin.page.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Страницы');

        return inertia('Modules/Page/Index', [
            'filters' => Request::all('search', 'active'),
            'pages' => PageResource::collection(
                Page::query()
                    ->filter(Request::only('search', 'active'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)->withQueryString()
            ),
        ]);
    }

    public function show(Page $page): \Illuminate\Http\Response
    {
        $view = $page->template && view()->exists('pages.' . $page->template) ? 'pages.' . $page->template : 'pages.default';
        return response()->view($view, [
            'page' => $page,
        ]);
    }

    public function create(PageService $pageService): \Inertia\Response
    {
        Seo::metaData()->setTitle('Создать страницу');
        Seo::breadcrumbs()->add('Создать', route('admin.page.create'));
        $page = new Page();
        return inertia('Modules/Page/Edit', [
            'templates' => $pageService->getTemplates(),
            'model' => get_class($page),
            'images' => ImageResource::collection(Image::getFreeImages($page, 'editor')),
            'files' => FileResource::collection(File::getFreeFiles($page, 'editor')),
            'preview' => ($preview = Image::getFreeImages($page, 'preview')?->first()) ?
                new ImageResource($preview) : null
        ]);
    }

    public function store(StoreRequest $request): PageResource
    {
        $page = new Page($request->validated());
        $page->save();
        return new PageResource($page);
    }

    public function edit(Page $page, PageService $pageService): \Inertia\Response
    {
        Seo::metaData()->setTitle('Изменить ' . $page->title);
        Seo::breadcrumbs()->add($page->title);
        Seo::breadcrumbs()->add('Изменить', route('admin.page.edit', $page->id));
        $page->load('files');
        return inertia('Modules/Page/Edit', [
            'templates' => $pageService->getTemplates(),
            'page' => new PageResource($page),
            'model' => get_class($page),
            'images' => ImageResource::collection($page->getImagesByGroup('editor')),
        ]);
    }

    public function update(UpdateRequest $request, Page $page): PageResource
    {
        $page->update($request->validated());
        return new PageResource($page);
    }

    public function destroy(Page $page): \Illuminate\Http\RedirectResponse
    {
        $page->delete();
        return redirect()->route('admin.page.index');
    }
}
