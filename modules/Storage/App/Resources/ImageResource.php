<?php

namespace Modules\Storage\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'group' => $this->group,
            'full' => $this->getFull(),
            'preview' => $this->getPreview(),
            'prefix' => $this['prefix']
        ];
    }
}
