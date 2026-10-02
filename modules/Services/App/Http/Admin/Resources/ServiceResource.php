<?php

namespace Modules\Services\App\Http\Admin\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'parent_id'     => $this->parent_id,
            'name'          => $this->name,
            'alias'         => $this->alias,
            'price'         => $this->price,
            'content'       => $this->content,
            'description'   => $this->description,
            'sort_order'    => $this->sort_order,
            'is_active'     => $this->is_active,
            'is_featured'   => $this->is_featured,
            'created_at'    => $this->created_at->isoFormat('LLL'),

            'seo'           => SeoResource::make($this->whenLoaded('seo')),
        ];
    }
}
