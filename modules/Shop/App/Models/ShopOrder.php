<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\App\Events\OrderCreated;

class ShopOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_phone',
        'user_email',
        'price',
        'address',
        'status',
        'is_pickup',
    ];

    protected $casts = [
        'is_pickup' => 'boolean',
    ];

    public function pivotProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopOrderProduct::class, 'order_id', 'id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ShopProduct::class, 'shop_order_products', 'order_id', 'product_id')
            ->withPivot(['price', 'count'])->with('attributesValue');
    }

    public function sendNotifications()
    {
        event(new OrderCreated($this));
    }
}
