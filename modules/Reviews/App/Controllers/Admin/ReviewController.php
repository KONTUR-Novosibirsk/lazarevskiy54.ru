<?php

namespace Modules\Reviews\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Request;
use Modules\Reviews\App\Models\Review;
use Modules\Reviews\App\Requests\StoreRequest;
use Modules\Reviews\App\Requests\UpdateRequest;
use Modules\Reviews\App\Resources\ReviewResource;

class ReviewController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'reviews', 'Отзывы'), route('admin.review.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'reviews', 'Отзывы'));

        return inertia('Modules/Review/Index', [
            'filters' => Request::all('search', 'status'),
            'reviews' => ReviewResource::collection(
                Review::query()->filter(Request::only('search', 'status'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('sort')
                    ->orderBy('id', 'DESC')
                    ->paginate(auth()->user()->per_page)->withQueryString()
            ),
        ]);
    }

    public function store(StoreRequest $request): ReviewResource
    {
        $review = new Review($request->validated());
        $review->save();
        return new ReviewResource($review);
    }

    public function update(UpdateRequest $request, Review $review): ReviewResource
    {
        $data = $request->validated();
        $review->update($data);
        return new ReviewResource($review);
    }

    public function changeStatus(Review $review): ReviewResource
    {
        $review->status = ($review->status == 1 ? 0 : 1);
        $review->save();
        return new ReviewResource($review);
    }

    public function destroy(Review $review): \Illuminate\Http\RedirectResponse
    {
        $review->delete();
        return redirect()->back();
    }

    /**
     * Обновление сортировки отзыва
     *
     * @param \Illuminate\Http\Request $request
     * @param Review $review
     * @return JsonResponse
     */
    public function updateSort(\Illuminate\Http\Request $request, Review $review): JsonResponse
    {
        $review['sort'] = $request->input(key: 'sort');
        $review->save();

        return response()->json(['success' => true]);
    }

    /**
     * Получение записей согласно заданной сортировки
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getReviewSort(\Illuminate\Http\Request $request): JsonResponse
    {
        $sort = $request->input(key: 'sort');
        $page = $request->input('page', 1);
        $perPage = auth()->user()->per_page ?? 10;

        $query = Review::query()
            ->filter(Request::only('search', 'status'))
            ->sort(Request::only('order_by', 'order_direction'))
            ->orderBy('sort', $sort)
            ->orderBy('id', $sort);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $reviews = ReviewResource::collection(
            $query->paginate($perPage)->withQueryString()
        );

        return response()->json(['reviews' => $reviews]);
    }
}
