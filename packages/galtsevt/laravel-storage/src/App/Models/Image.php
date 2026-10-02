<?php

namespace Galtsevt\LaravelStorage\App\Models;

use Galtsevt\LaravelStorage\App\Interfaces\{HasImageInterface, Imageable};
use Galtsevt\LaravelStorage\App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model implements HasImageInterface
{
    use HasFactory, HasImage;

    protected bool $imageHasThumbnail = false;

    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'group',
    ];

    public static function booting(): void
    {
        static::creating(function (HasImageInterface $model) {
            if ($model->imageHasThumbnail()) {
                $model->with_thumbnail = true;
                $model->user_id = auth()->user()->id ?? null;
            }
        });
        static::deleting(function (HasImageInterface $model) {
            if (Image::query()->where('name', $model->name)->count() === 1)
                $model->deleteImage();
        });
    }

    public function imageHasThumbnail(): bool
    {
        return true;
    }

    public static function getFreeImages(Imageable $model, $group = null): \Illuminate\Database\Eloquent\Collection
    {
        return self::query()->whereNull('imageable_id')->where([
            ['imageable_type', $model->getMorphClass()],
            ['user_id', auth()->id()],
        ])->when($group, fn($query) => $query->where('group', $group))->orderBy('sort')->get();
    }

    public static function freeImagesAppendToModel(Imageable $model): int
    {
        return self::query()->whereNull('imageable_id')->where([
            ['imageable_type', $model->getMorphClass()],
            ['user_id', auth()->id()],
        ])->update(['imageable_id' => $model->id]);
    }
}
