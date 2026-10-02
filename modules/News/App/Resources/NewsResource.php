<?php

namespace Modules\News\App\Resources;

use Galtsevt\LaravelSeo\App\Resources\SeoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Storage\App\Resources\FileResource;
use Modules\Storage\App\Resources\ImageResource;


class NewsResource extends JsonResource
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
            'preview_text' => $this->preview_text,
            'active' => $this->active,
            'seo' => new SeoResource($this->seo),
            'preview' => new ImageResource($this->image()),
            'files' => FileResource::collection($this->whenLoaded('files', fn() => $this->getFilesByGroup('editor'))),
            'publication_date' => $this->publication_date ? $this->publication_date->format('Y-m-d H:i:s') : null,
            'publication_date_for_human' => $this->publication_date ? $this->publication_date->isoFormat('LLL') : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort' => $this['sort']
        ];
    }
}
