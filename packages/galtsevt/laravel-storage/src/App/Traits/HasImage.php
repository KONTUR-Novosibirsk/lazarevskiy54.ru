<?php

namespace Galtsevt\LaravelStorage\App\Traits;

use Galtsevt\LaravelStorage\App\Interfaces\HasImageInterface;
use Galtsevt\LaravelStorage\App\Services\ImageStorage;
use Illuminate\Support\Facades\File;

trait HasImage
{
    protected ?ImageStorage $imageStorage = null;

    public static function bootHasImage(): void
    {
        static::saving(function (HasImageInterface $model) {
            if ($model->imageStorage()->hasImage()) {
                if ($model->{$model->getImageAttribute()}) {
                    $model->deleteImage();
                }
                $model->{$model->getImageAttribute()} = $model->imageStorage()
                    ->save($model->getFolderName(), $model->imageHasThumbnail());
            }
        });
        static::deleting(function (HasImageInterface $model) {
            $model->deleteImage();
        });
    }

    public function loadImage($image, int $quality = 100): static
    {
        $this->imageStorage()->load($image, $quality);
        return $this;
    }

    public function loadImageFromFile(): static
    {
        $this->loadImage(
            $this->imageStorage()->getPath($this->getFolderName())
            . DIRECTORY_SEPARATOR
            . $this->{$this->getImageAttribute()}
        );
        return $this;
    }

    public function imageStorage(): ImageStorage
    {
        return $this->imageStorage ?? $this->imageStorage = new ImageStorage();
    }

    public function deleteImage(): bool
    {
        return $this->imageStorage()->delete($this->getFolderName(), $this->{$this->getImageAttribute()});
    }

    protected function getFolderName(): string
    {
        $class = $this->imageable_type ?? $this->getMorphClass();
        $classItems = explode('\\', $class);
        return strtolower(end($classItems));
    }

    public function getFull(): string
    {
        return $this->getImagePath('full') . $this->{$this->getImageAttribute()};
    }

    public function getPreview(): ?string
    {
        return $this->imageHasThumbnail() ? $this->getImagePath('thmb') . $this->{$this->getImageAttribute()} : null;
    }

    public function getImageAttribute(): string
    {
        return 'name';
    }

    public function imageHasThumbnail(): bool
    {
        return false;
    }

    protected function getImagePath($type): string
    {
        return request()->getSchemeAndHttpHost() . '/storage/images/' . $this->getFolderName() . '/' . $type . '/';
    }

    public function optimizeResolution(): static
    {
        $this->imageStorage->optimizeResolution();
        return $this;
    }

    public function crop(int $width, int $height, int $offsetX = 0, int $offsetY = 0): static
    {
        $this->imageStorage->crop($width, $height, $offsetX, $offsetY);
        return $this;
    }
}
