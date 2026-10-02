<?php

namespace Modules\InfoBlocks\App\Models;

use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoBlockElement extends Model implements Imageable
{
    use HasFactory, HasImages;

    protected $fillable = [
        'description',
        'title',
        'props',
        'info_block_id',
    ];

    protected $casts = [
        'props' => 'collection',
    ];

    public function image()
    {
        return $this->getImagesByGroup('preview')?->first();
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InfoBlock::class, 'info_block_id', 'id');
    }

    public function imageGroups(): array
    {
        return [
            'preview' => [
                'single' => true,
            ],
        ];
    }
}
