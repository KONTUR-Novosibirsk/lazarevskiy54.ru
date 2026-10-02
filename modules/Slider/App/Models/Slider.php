<?php

namespace Modules\Slider\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $casts = [
        'props' => 'array',
    ];

    protected $fillable = [
        'name',
        'code',
        'description',
        'props',
    ];

    public function slides(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Slide::class, 'slider_id', 'id')->orderBy('sort');
    }
}
