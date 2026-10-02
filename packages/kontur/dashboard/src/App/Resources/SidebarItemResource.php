<?php

namespace Kontur\Dashboard\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SidebarItemResource extends JsonResource
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
            'icon' => $this->getIcon() ?? '',
            'route_name' => $this->getRouteName(),
            'has_menu_items' => $this->hasMenuItems(),
            'children' => $this->hasMenuItems() ? SidebarItemResource::collection($this->getMenuItems()) : [],
        ];
    }
}
