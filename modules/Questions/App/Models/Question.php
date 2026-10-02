<?php

namespace Modules\Questions\App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kontur\Dashboard\App\Casts\HtmlPurify;

class Question extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'question',
        'response',
        'status',
    ];

    protected $casts = [
        'question' => HtmlPurify::class,
        'response' => HtmlPurify::class,
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('text', 'like', '%' . $search . '%');
        })->when(isset($filters['status']) && is_numeric($filters['status']), function ($query, $active) use ($filters) {
            if ($filters['status'] == 2) {
                $query->whereNull('response');
            } else {
                $query->where('status', '=', $filters['status']);
            }
        });
    }
}
