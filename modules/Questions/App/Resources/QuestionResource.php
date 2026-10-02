<?php

namespace Modules\Questions\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question' => $this->question,
            'response' => $this->response,
            'status' => $this->status,
            'created_at' => $this->created_at->isoFormat('LLL'),
        ];
    }
}
