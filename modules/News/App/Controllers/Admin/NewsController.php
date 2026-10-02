<?php

namespace Modules\News\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\News\App\Models\News;
use Modules\News\App\Requests\{DraftUpdateRequest, UpdateRequest};
use Modules\News\App\Resources\NewsResource;
use Modules\Storage\App\Resources\ImageResource;

class NewsController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'news', 'Новости'), route('admin.news.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'news', 'Новости'));

        return inertia('Modules/News/Index', [
            'filters' => Request::all('search', 'active'),
            'news' => NewsResource::collection(
                News::query()->with(['images', 'seo'])
                    ->filter(Request::only('search', 'active'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('sort')
                    ->orderBy('id', 'DESC')
                    ->paginate(auth()->user()->per_page)->withQueryString()
            ),
        ]);
    }

    public function show(News $news): \Illuminate\Http\Response
    {
        return response()->view('news::show', [
            'news' => $news,
        ]);
    }

    public function store()
    {
        if (News::query()->whereNull(['title', 'text'])->where('active', 0)->count() > 2) {
            return redirect()->route('admin.news.index')->with('error', 'Слишком много пустых черновиков');
        }

        $news = new News(['user_id' => auth()->id(), 'publication_date' => Carbon::now()]);
        if ($news->save()) {
            return redirect()->route('admin.news.edit', $news->id)->with('success', 'Создан пустой черновик');
        }
        return redirect()->route('admin.news.index')->with('error', 'Не удалось создать новость');
    }

    public function edit(News $news): \Inertia\Response
    {
        Seo::breadcrumbs()->add('Редактирование новости', route('admin.news.edit', $news->id));
        Seo::metaData()->setTitle('Редактирование новости');

        $news->load('files');
        return inertia('Modules/News/Edit', [
            'news' => new NewsResource($news),
            'images' => ImageResource::collection($news->getImagesByGroup('editor')),
            'model' => News::class,
        ]);
    }

    public function saveAsDraft(News $news, DraftUpdateRequest $request): NewsResource
    {
        $data = $request->validated();
        $news->active = false;
        $news->update($data);
        return new NewsResource($news);
    }

    public function update(News $news, UpdateRequest $request): NewsResource
    {
        $data = $request->validated();
        $news->active = true;
        $news->update($data);
        return new NewsResource($news);
    }

    public function destroy(News $news): \Illuminate\Http\RedirectResponse
    {
        $news->delete();
        return redirect()->back();
    }

    /**
     * Обновление сортировки новости
     *
     * @param \Illuminate\Http\Request $request
     * @param News $news
     * @return JsonResponse
     */
    public function updateSort(\Illuminate\Http\Request $request, News $news): JsonResponse
    {
        $news['sort'] = $request->input(key: 'sort');
        $news->save();

        return response()->json(['success' => true]);
    }

    /**
     * Получение записей согласно заданной сортировки
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getNewsSort(\Illuminate\Http\Request $request): JsonResponse
    {
        $sort = $request->input(key: 'sort');
        $page = $request->input('page', 1);
        $perPage = auth()->user()->per_page ?? 10;

        $query = News::query()
            ->with(['images', 'seo'])
            ->filter($request->only('search', 'active'))
            ->sort($request->only('order_by', 'order_direction'))
            ->orderBy('sort', $sort)
            ->orderBy('id', $sort);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $news = NewsResource::collection(
            $query->paginate($perPage)->withQueryString()
        );

        return response()->json(['news' => $news]);
    }
}
