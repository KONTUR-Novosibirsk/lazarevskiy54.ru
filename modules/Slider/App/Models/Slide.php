<?php

namespace Modules\Slider\App\Models;

use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model implements Imageable
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'description',
        'link',
        'props',
        'slide_id',
        'sort'
    ];
    protected $casts = [
        'props' => 'array',
    ];

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ]
        ];
    }

    public function slider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Slider::class, 'slider_id', 'id');
    }
}
