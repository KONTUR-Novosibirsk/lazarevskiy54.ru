<?php

namespace Galtsevt\LaravelSeo\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateSeoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getName(),
            'model_type' => $this->getModel(),
            'seo' => new SeoResource($this->getSeo()),
        ];
    }
}
