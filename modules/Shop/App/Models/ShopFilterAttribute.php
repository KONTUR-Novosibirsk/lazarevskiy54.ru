<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopFilterAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort',
        'type',
        'attribute_id',
        'filter_id',
    ];

    public function filter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopFilter::class, 'filter_id', 'id');
    }
}
