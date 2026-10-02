<?php

namespace Modules\Shop\App\Resources\Filter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shop\App\Models\ShopFilterAttribute;

class ShopFilterResource extends JsonResource
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
            'attributes' => ShopFilterAttributeResource::collection($this->whenLoaded('shopAttributes')),
        ];
    }
}
