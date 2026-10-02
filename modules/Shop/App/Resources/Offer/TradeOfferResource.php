<?php

namespace Modules\Shop\App\Resources\Offer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shop\App\Resources\ShopAttributeResource;
use Modules\Shop\App\Resources\ShopProductResource;

class TradeOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'products' => ShopProductResource::collection($this->whenLoaded('products')) ?? [],
            'attributes' => ShopAttributeResource::collection($this->whenLoaded('attributes')) ?? [],
            'sort' => $this['sort']
        ];
    }
}
