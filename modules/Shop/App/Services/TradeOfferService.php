<?php

namespace Modules\Shop\App\Services;

use Modules\Shop\App\Models\ShopProduct;
use Modules\Shop\App\Models\ShopTradeOffer;
use Modules\Shop\App\Requests\Offer\StoreRequest;
use Modules\Shop\App\Requests\Offer\UpdateRequest;

class TradeOfferService
{
    public function store(StoreRequest $request): ShopTradeOffer
    {
        $data = $request->validated();
        $offer = new ShopTradeOffer($data);
        $offer->save();
        $this->syncData($offer, $data);
        return $offer;
    }

    public function update(UpdateRequest $request, ShopTradeOffer $tradeOffer): ShopTradeOffer
    {
        $data = $request->validated();
        $tradeOffer->update($data);
        $this->syncData($tradeOffer, $data);
        return $tradeOffer;
    }

    public function syncData(ShopTradeOffer $tradeOffer, $data): void
    {
        if (isset($data['products'])) {
            $tradeOffer->products()->update([
                'trade_offer_id' => null,
            ]);
            ShopProduct::query()->whereIn('id', collect($data['products'])->pluck('id'))
                ->update([
                    'trade_offer_id' => $tradeOffer->id,
                ]);
        }

        if (isset($data['attributes'])) {
            $sort = 1;
            foreach ($data['attributes'] as $attribute) {
                $attributes[$attribute['id']] = ['sort' => $sort];
                $sort++;
            }
            $tradeOffer->attributes()->sync($attributes);
        }

        $tradeOffer->load('products', 'attributes');
    }
}
