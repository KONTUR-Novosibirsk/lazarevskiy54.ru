<?php

namespace Galtsevt\LaravelSeo\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
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
            'h1' => $this->h1,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'site_map' => $this->site_map,
            'changefreq' => $this->changefreq,
            'priority' => $this->priority,
        ];
    }
}
