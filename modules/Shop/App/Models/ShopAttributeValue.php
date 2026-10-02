<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopAttributeValue extends Model
{
    use HasFactory;

    protected $with = ['attribute'];

    protected $fillable = [
        'value',
        'attribute_id',
        'product_id',
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopAttribute::class, 'attribute_id', 'id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
}
