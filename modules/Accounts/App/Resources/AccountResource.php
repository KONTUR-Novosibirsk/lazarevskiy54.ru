<?php

namespace Modules\Accounts\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\App\Models\Account;
use Modules\Storage\App\Resources\ImageResource;

class AccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'login' => $this->login,
            'phone' => $this->phone,
            'is_confirmed' => $this->is_confirmed,
            'order_count' => $this->orders->count(),
            'updated_at' => $this->updated_at->isoFormat('LLL'),
            'created_at' => $this->created_at->isoFormat('LLL'),
        ];
    }
}

