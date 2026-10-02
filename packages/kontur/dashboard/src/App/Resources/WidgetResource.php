<?php

namespace Kontur\Dashboard\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'data' => $this->getData(),
            'sort' => $this->getSort(),
            'size' => $this->getSize(),
            'active' => $this->isActive(),
            'description' => $this->getDescription(),
        ];
    }
}
