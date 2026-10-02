<?php

namespace Modules\Reviews\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'job_title' => $this->job_title,
            'text' => $this->text,
            'status' => $this->status,
            'created_at' => $this->created_at->isoFormat('LLL'),
            'sort' => $this['sort']
        ];
    }
}
