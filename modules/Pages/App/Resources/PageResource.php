<?php

namespace Modules\Pages\App\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Storage\App\Resources\FileResource;
use Modules\Storage\App\Resources\ImageResource;

class PageResource extends JsonResource
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
            'template' => $this->template,
            'active' => $this->active,
            'seo' => new SeoResource($this->seo),
            'preview' => $this->image() ? new ImageResource($this->image()) : null,
            'files' => FileResource::collection($this->whenLoaded('files', fn() => $this->getFilesByGroup('editor'))),
            'created_date_for_human' => $this->created_at ? $this->created_at->isoFormat('LLL') : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
