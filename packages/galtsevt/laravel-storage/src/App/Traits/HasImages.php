<?php

namespace Galtsevt\LaravelStorage\App\Traits;

use Galtsevt\LaravelStorage\App\Interfaces\Imageable;
use Galtsevt\LaravelStorage\App\Models\Image;

trait HasImages
{
    public static function bootHasImages(): void
    {
        static::created(function (Imageable $model) {
            if (config('laravel-storage.auto_attach')) {
                Image::freeImagesAppendToModel($model);
            }
        });
        static::deleting(function (Imageable $model) {
            $model->deleteImages();
        });
    }

    public function imageGroups(): array
    {
        return [];
    }

    /**
     * Loading free images and set to relations.
     * @return $this
     */
    public function loadFreeImages(): static
    {
        if (!$this->relationLoaded('images')) {
            $this->setRelation('images', $this->getFreeImages());
        }
        return $this;
    }

    public function getFreeImages($group = null): \Illuminate\Database\Eloquent\Collection
    {
        return Image::getFreeImages($this, $group);
    }

    protected function imageIsSingleInGroup($group): bool
    {
        return isset($this->imageGroups()[$group]) && $this->imageGroups()[$group]['single'];
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getImagesByGroup($type): ?\Illuminate\Database\Eloquent\Collection
    {
        return $this->images?->where('group', $type)->sortBy('sort');
    }

    public function loadImage($image, string $group, string $prefix = null): Image
    {
        if (($withOneImage = $this->imageIsSingleInGroup($group)) && $this->id) {
            $imageModel = $this->getImagesByGroup($group)?->first();
        } elseif ($withOneImage) {
            $imageModel = Image::getFreeImages($this, $group)?->first();
        }
        $imageModel = $imageModel ?? new Image();

        if ($prefix) $imageModel->prefix = $prefix;

        $imageModel->group = $group;
        $imageModel->imageable_type = $this->getMorphClass();
        $imageModel->imageable_id = $this->id ?? null;
        $imageModel->loadImage($image);
        return $imageModel;
    }

    public function deleteImages(): void
    {
        foreach ($this->images as $image) {
            $image->delete();
        }
    }
}
