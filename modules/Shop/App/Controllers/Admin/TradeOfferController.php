<?php

namespace Modules\Shop\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Modules\Shop\App\Models\ShopAttribute;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Models\ShopTradeOffer;
use Modules\Shop\App\Requests\Offer\StoreRequest;
use Modules\Shop\App\Requests\Offer\UpdateRequest;
use Modules\Shop\App\Resources\Offer\TradeOfferResource;
use Modules\Shop\App\Resources\ShopAttributeResource;
use Modules\Shop\App\Resources\ShopCategoryResource;
use Modules\Shop\App\Resources\ShopProductResource;
use Modules\Shop\App\Services\NestedService;
use Modules\Shop\App\Services\TradeOfferService;

class TradeOfferController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(
            name: settings('name', 'shop', 'Магазин'),
            url: route('admin.shop.index')
        );
    }

    public function tradeOffers(ShopCategory $shopCategory, NestedService $nestedService): \Inertia\Response
    {
        Seo::metaData()->setTitle($shopCategory->title);
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        Seo::breadcrumbs()->add('Торговые предложения');

        return inertia('Modules/Shop/Offer/Index', [
            'offers' => TradeOfferResource::collection($shopCategory->offers()
                ->orderBy('sort')->paginate(auth()->user()->per_page)),
            'category' => new ShopCategoryResource($shopCategory),
        ]);
    }

    public function create(ShopCategory $shopCategory, NestedService $nestedService): \Inertia\Response
    {
        Seo::metaData()->setTitle('Создать торговое предложение');
        $nestedService->createChainOfBreadcrumbs($shopCategory);
        Seo::breadcrumbs()->addList([
                route('admin.shop.offer.index', $shopCategory->id) => 'Торговые предложения',
                'Добавить',
            ]
        );

        return inertia('Modules/Shop/Offer/Form', [
            'products' => ShopProductResource::collection($shopCategory->products()
                ->with(['images', 'attributesValue'])
                ->whereNull('trade_offer_id')
                ->get()),
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->where('type', 'select')->get()
            ),
            'category' => new ShopCategoryResource($shopCategory),
        ]);
    }

    public function store(StoreRequest $request, TradeOfferService $tradeOfferService): TradeOfferResource
    {
        return new TradeOfferResource($tradeOfferService->store($request));
    }

    public function edit(ShopTradeOffer $tradeOffer, NestedService $nestedService): \Inertia\Response
    {
        Seo::metaData()->setTitle('Изменить торговое предложение');
        $nestedService->createChainOfBreadcrumbs($tradeOffer->category);
        Seo::breadcrumbs()->addList([
                route('admin.shop.offer.index', $tradeOffer->category->id) => 'Торговые предложения',
                $tradeOffer->name,
                'Изменить',
            ]
        );

        $tradeOffer->load(['products', 'attributes']);
        return inertia('Modules/Shop/Offer/Form', [
            'offer' => new TradeOfferResource($tradeOffer),
            'products' => ShopProductResource::collection($tradeOffer->category->products()
                ->with('images', 'attributesValue')
                ->whereNull('trade_offer_id')
                ->orWhere('trade_offer_id', $tradeOffer->id)
                ->get()),
            'attributes' => ShopAttributeResource::collection(
                ShopAttribute::query()->where('type', 'select')->get()
            ),
        ]);
    }

    public function update(UpdateRequest $request, ShopTradeOffer $tradeOffer, TradeOfferService $tradeOfferService): TradeOfferResource
    {
        return new TradeOfferResource($tradeOfferService->update($request, $tradeOffer));
    }

    public function destroy(ShopTradeOffer $tradeOffer): \Illuminate\Http\RedirectResponse
    {
        $tradeOffer->delete();
        return redirect()->route('admin.shop.offer.index', ['shopCategory' => $tradeOffer['category_id']]);
    }

    /**
     * Обновление сортировки торгового предложения
     *
     * @param Request $request
     * @param ShopTradeOffer $tradeOffer
     * @return JsonResponse
     */
    public function updateSort(Request $request, ShopTradeOffer $tradeOffer): JsonResponse
    {
        $tradeOffer['sort'] = $request->input(key: 'sort');
        $tradeOffer->save();

        return response()->json(['success' => true]);
    }

    /**
     * Получение записей согласно заданной сортировки
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOfferSort(Request $request): JsonResponse
    {
        $sort = $request->input(key: 'sort');
        $page = $request->input('page', 1);
        $category = ShopCategory::query()->find($request->input('categoryId'));
        $perPage = auth()->user()->per_page ?? 10;

        $query = $category->offers()
            ->orderBy('sort', $sort)
            ->orderBy('id', $sort);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $offers = TradeOfferResource::collection(
            $query->paginate($perPage)->withQueryString()
        );

        return response()->json(['offers' => $offers]);
    }
}
