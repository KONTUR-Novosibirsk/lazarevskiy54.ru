<?php

namespace Modules\Menu\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'url' => $this->url,
            'route_name' => $this->route_name,
            'route_attributes' => $this->route_attributes,
            'branch_class' => $this->branch_class,
            'is_branched' => is_bool($this->is_branched) ? $this->is_branched : false,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'children' => $this->children ? MenuItemResource::collection($this->children) : [],
        ];
    }
}
