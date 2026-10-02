<?php

namespace Modules\Sale\App\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Storage\App\Resources\ImageResource;

class SaleResource extends JsonResource
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
            'text' => $this->text,
            'active' => $this->isActive(),
            'start_date' => $this->start_date->format('Y-m-d\TH:i:s'),
            'end_date' => $this->end_date->format('Y-m-d\TH:i:s'),
            'seo' => new SeoResource($this->seo),
            'preview' => $this->image() ? new ImageResource($this->image()) : null,
            'created_date_for_human' => $this->created_at->isoFormat('LLL'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this['sort']
        ];
    }
}
