<?php

namespace Modules\Shop\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function shopAttributes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShopFilterAttribute::class, 'filter_id', 'id')->orderBy('sort');
    }
}
