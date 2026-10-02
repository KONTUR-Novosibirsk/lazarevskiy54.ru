<?php

namespace Modules\Reviews\App\Models;

use App\Models\BaseModel;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kontur\Dashboard\App\Casts\HtmlPurify;

class Review extends BaseModel
{
    use HasFactory;

    protected $guarded = false;
    protected $casts = [
        'text' => HtmlPurify::class,
    ];

    protected static function newFactory(): ReviewFactory
    {
        return ReviewFactory::new();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('text', 'like', '%' . $search . '%');
        })->when(isset($filters['status']) && in_array($filters['status'], [0, 1]), function ($query, $active) use ($filters) {
            $query->where('status', '=', $filters['status']);
        });
    }
}
