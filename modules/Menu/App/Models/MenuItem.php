<?php

namespace Modules\Menu\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Kalnoy\Nestedset\NodeTrait;

class MenuItem extends Model
{
    use HasFactory, NodeTrait;

    protected $casts = [
        'route_attributes' => 'array',
        'is_branched' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'url',
        'route_name',
        'route_attributes',
        'parent_id',
        'branch_class',
        'is_branched',
        'sort',
        'category_id',
        'model_type',
        'model_id',
    ];

    public function isActive(): bool
    {
        return str_contains(url()->current(), $this->link());
    }

    public function link(): string
    {
        try {
            if ($this->url) {
                return url($this->url);
            }

            if (!Route::has($this->route_name)) {
                return '#';
            }

            return route($this->route_name, $this->route_attributes['alias'] ?? null);
        } catch (\Exception $e) {
            \Log::error('Error in link method', ['exception' => $e]);
            return '#';
        }
    }
}
