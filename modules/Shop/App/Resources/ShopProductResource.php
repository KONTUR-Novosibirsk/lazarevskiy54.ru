<?php

namespace Modules\Shop\App\Resources;

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
            'active' => $this->active,
            'hit' => $this->hit,
            'show_on_index_page' => $this->show_on_index_page,
            'show_on_shop_index_page' => $this->show_on_shop_index_page,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'attributes_for_edit' => $this->whenLoaded('attributesValue', fn() => $this->attributesForEdit()),
            'attributes' => ShopAttributeValueResource::collection($this->whenLoaded('attributesValue')),
            'preview' => ImageResource::collection($this->getImagesByGroup('preview')),
            'first_preview' => $this->previewImages()->first()?->getPreview(),
            'sort' => $this['sort']
        ];
    }
}
