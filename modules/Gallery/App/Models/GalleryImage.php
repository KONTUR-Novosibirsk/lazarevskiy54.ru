<?php

namespace Modules\Gallery\App\Models;

use Database\Factories\GalleryImageFactory;
use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model implements Imageable
{
    use HasFactory, HasImages;

    protected $with = ['images'];
    protected $fillable = [
        'name',
        'text',
        'gallery_id',
    ];

    protected static function newFactory(): GalleryImageFactory
    {
        return GalleryImageFactory::new();
    }

    public function image()
    {
        return $this->getImagesByGroup('main')?->first();
    }

    public function imageGroups(): array
    {
        return [
            'main' => [
                'single' => true,
            ],
        ];
    }
}
