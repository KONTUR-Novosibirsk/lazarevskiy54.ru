<?php

namespace Modules\InfoBlocks\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoBlockCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function infoBlocks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InfoBlock::class, 'category_id', 'id');
    }
}
