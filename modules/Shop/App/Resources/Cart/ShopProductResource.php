<?php

namespace Modules\Shop\App\Resources\Cart;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Modules\Storage\App\Resources\ImageResource;

class ShopProductResource extends JsonResource
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
            'title' => $this->title,
            'alias' => $this->alias,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'sale' => $this->sale,
            'url' => $this->createUrl(),
            'count' => $this->count,
            'hash' => $this->hash,
            'first_preview' => $this->previewImages()->first()?->getPreview()
        ];
    }
}
