<?php

namespace Modules\Reviews\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Reviews\App\Models\Review;
use Modules\Reviews\App\Requests\StoreFromPublicRequest;
use Modules\Reviews\App\Resources\ReviewResource;

class ReviewController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'reviews', 'Отзывы'));
    }

    public function index(): \Illuminate\Http\Response
    {
        Seo::metaData()->setTitle(settings('name', 'reviews', 'Отзывы'));

        return response()->view('reviews::index', [
            'reviews' => Review::query()->where('status', 1)->orderBy('sort')->orderByDesc('id')
                ->paginate(settings('per_page', default: 10)),
        ]);
    }

    public function store(StoreFromPublicRequest $request): ReviewResource
    {
        $review = new Review($request->validated());
        $review->save();
        return new ReviewResource($review);
    }
}
