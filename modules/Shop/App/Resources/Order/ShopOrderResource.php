<?php

namespace Modules\Shop\App\Resources\Order;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Modules\Storage\App\Resources\ImageResource;

class ShopOrderResource extends JsonResource
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
            'user_name' => $this->user_name,
            'user_phone' => $this->user_phone,
            'user_email' => $this->user_email,
            'price' => $this->price,
            'address' => $this->address,
            'status' => $this->status,
            'is_pickup' => $this->is_pickup,
            'date_for_human' => $this->created_at->isoFormat('LLL'),
            'updated_at' => $this->updated_at->isoFormat('LLL'),
        ];
    }
}
