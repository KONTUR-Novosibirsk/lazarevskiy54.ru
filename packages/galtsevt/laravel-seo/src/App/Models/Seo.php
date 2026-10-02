<?php

namespace Galtsevt\LaravelSeo\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'laravel_seo';
    protected $casts = [
        'site_map' => 'boolean',
    ];

    public function relatedModel(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('model');
    }

}
