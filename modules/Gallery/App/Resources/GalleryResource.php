<?php

namespace Modules\Gallery\App\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Storage\App\Resources\ImageResource;

class GalleryResource extends JsonResource
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
            'alias' => $this->alias,
            'text' => $this->text,
            'active' => $this->active,
            'seo' => new SeoResource($this->whenLoaded('seo')),
            'image' => new ImageResource($this->image),
            'images' => GalleryImageResource::collection($this->whenLoaded('images')),
            'images_count' => $this->images_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
