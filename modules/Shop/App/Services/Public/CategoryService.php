<?php

namespace Modules\Shop\App\Services\Public;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Modules\Shop\App\Contracts\ProductFilterContract;
use Modules\Shop\App\Filters\ProductFilter;
use Modules\Shop\App\Models\ShopCategory;

class CategoryService
{
    public function __construct(
        protected Request $request,
    )
    {

    }

    public function productsOrTradeOffers(ShopCategory $shopCategory, ProductFilterContract $filter)
    {
        $mergeData = settings('with_trade_offers', 'shop', false) ?
            $this->tradeOffers($shopCategory, $filter) : $this->products($shopCategory, $filter);

        return $this->request->ajax() ? [
            'html' => view('shop::partial.products', array_merge([
                'category' => $shopCategory,
            ], $mergeData))->render(),
            'url' => url()->full(),
        ] : response()->view('shop::category', array_merge([
            'filterData' => $this->request->all(),
            'category' => $shopCategory,
            'categories' => $shopCategory->children,
            'sortAttributes' => ProductFilter::getSortAttributes(),
            'filterableAttributes' => $shopCategory->getFilterableAttributes(),
        ], $mergeData));
    }

    protected function tradeOffers(ShopCategory $shopCategory, ProductFilterContract $filter)
    {
        return [
            'offers' => $shopCategory->offers()->orderBy('sort')->publicFilter($filter)
                ->with(['products' => fn (HasMany $query) => $query->where('active', true), 'products.images'])
                ->paginate(settings('per_page', default: 10))->withQueryString(),
        ];
    }

    protected function products(ShopCategory $shopCategory, ProductFilterContract $filter)
    {
        return [
            'products' => $shopCategory->products()->orderBy('sort')->publicFilter($filter)->where('active', 1)
                ->with(['images'])->paginate(settings('per_page', default: 10))->withQueryString(),
        ];
    }
}
