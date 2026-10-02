<?php

namespace Kontur\Dashboard\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModulesResource extends JsonResource
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
            'config' => $this->getConfig(),
            'hasSettings' => (bool)config('admin_settings.groups.' . $this->getId()),
        ];
    }
}
