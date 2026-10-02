<?php

namespace Modules\InfoBlocks\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kontur\Dashboard\App\Casts\HtmlPurify;

class InfoBlock extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'props' => 'collection',
        'description' => HtmlPurify::class,
    ];

    public function elements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InfoBlockElement::class, 'info_block_id', 'id')->orderBy('sort');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InfoBlockCategory::class, 'category_id', 'id');
    }

}
