<?php

namespace Modules\Widgets\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetNote extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function scopeLast(Builder $query): void
    {
        $query->orderBy('id', 'DESC')->limit(7);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('text', 'like', '%' . $search . '%');
        });
    }
}
