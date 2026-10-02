<?php

namespace Modules\Shop\App\Models;

use App\Models\BaseModel;
use Database\Factories\ShopAttributeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopAttribute extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'dictionary' => 'array',
    ];

    protected $fillable = [
        'name',
        'type',
        'dictionary',
    ];

    protected static function newFactory(): ShopAttributeFactory
    {
        return ShopAttributeFactory::new();
    }

    protected static function booted(): void
    {
        static::saving(function (ShopAttribute $shopAttribute) {
            if ($shopAttribute->type == 'input') {
                $shopAttribute->dictionary = null;
            }
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', '=', $type);
        });
    }

    public function values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopAttributeValue::class, 'attribute_id', 'id');
    }


}
