<?php

namespace Modules\News\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\News\App\Models\News;

class NewsController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'news', 'Новости'), route('news.index'));
    }

    public function index(): \Illuminate\Http\Response
    {
        Seo::metaData()->setTitle(settings('name', 'news', 'Новости'));

        return response()->view('news::index', [
            'news' => News::query()->with(['images'])->active()->orderBy('sort')
                ->paginate(settings('per_page', default: 10)),
        ]);
    }

    public function show($alias): \Illuminate\Http\Response
    {
        $news = News::query()->with(['seo'])->where('alias', $alias)->active()->firstOrFail();

        Seo::metaData()->setTitle($news->title)->prepare($news)->withTemplate();
        Seo::breadcrumbs()->add($news->title, route('news.show', $news));

        return response()->view('news::show', [
            'news' => $news,
        ]);
    }
}
