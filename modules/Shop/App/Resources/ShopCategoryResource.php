<?php

namespace Modules\Shop\App\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Storage\App\Resources\ImageResource;

class ShopCategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'show_on_index_page' => $this->show_on_index_page,
            'description' => $this->description,
            'filter_id' => $this->filter_id,
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'preview' => new ImageResource($this->image()),
            'descendants_count' => $this->descendants_count ?? null,
            'nested_products_count' => $this->nestedProductsCount(),
            'sort' => $this['sort']
        ];
    }
}
