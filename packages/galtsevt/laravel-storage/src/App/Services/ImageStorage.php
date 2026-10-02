<?php

namespace Galtsevt\LaravelStorage\App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\Encoders\{AutoEncoder, WebpEncoder};
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Interfaces\{EncodedImageInterface, EncoderInterface, ImageInterface};

class ImageStorage
{
    protected ?ImageInterface $image = null;
    protected EncoderInterface $encoder;
    protected string $name;
    protected string $mainPath = 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images';

    protected int $originWidth;
    protected int $thumbnailWidth;
    protected bool $progressive = false;

    public function __construct(int $originWidth = null, int $thumbnailWidth = null)
    {
        $this->originWidth = $originWidth ?? config('laravel-storage.default.width.origin', 1800);
        $this->thumbnailWidth = $this->thumbnailWidth ?? config('laravel-storage.default.width.thumbnail', 500);
    }

    public function load($image, int $quality = 90): static
    {
        $manager = new ImageManager(extension_loaded('imagick') ? new ImagickDriver() : new GdDriver());
        $this->image = $manager->read($image);

        if (config('laravel-storage.progressive_image')) {
            $this->progressive = true;
            $this->encoder = new WebpEncoder($quality);
            $this->image->toWebp();
        } else
            $this->encoder = new AutoEncoder($quality);
        return $this;
    }

    public function resize(?int $width = null, ?int $height = null): static
    {
        if ($width || $height)
            $this->image->scaleDown($width, $height);
        return $this;
    }

    public function crop(int $width, int $height, int $offsetX = 0, int $offsetY = 0): static
    {
        $this->image->crop($width, $height, $offsetX, $offsetY);
        return $this;
    }

    public function optimizeResolution(): static
    {
        if ($this->image->width() > $this->originWidth)
            $this->resize($this->originWidth);
        return $this;
    }

    protected function getExtension(): string
    {
        if ($this->progressive)
            return '.webp';
        if ($this->image->origin()->mediaType()) {
            $mediaType = $this->image->origin()->mediaType();
        } else {
            $encodedImage = $this->image->encode($this->encoder);
            $mediaType = $encodedImage->mediaType();
        }
        return match ($mediaType) {
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
            'image/gif' => '.gif',
            'image/webp' => '.webp',
            default => '.jpeg',
        };
    }

    protected function getName(): string
    {
        return $this->name ?? ($this->name = uniqid() . '_download' . $this->getExtension());
    }

    public function getPath(string $path, bool $isThumbnail = false): string
    {
        $dir = storage_path(
            $this->mainPath . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . ($isThumbnail ? 'thmb' : 'full')
        );

        if (!File::exists($dir))
            File::makeDirectory($dir, 0755, true);

        return $dir;
    }


    public function save(string $path, bool $withThumbnail = true): bool|string
    {
        if ($this->image->save($this->getPath($path) . DIRECTORY_SEPARATOR . $this->getName())) {
            if ($withThumbnail) {
                $this->resize($this->thumbnailWidth);
                $this->image->save($this->getPath($path, true) . DIRECTORY_SEPARATOR . $this->getName());
            }
            return $this->getName();
        }
        return false;
    }

    public function delete(string $path, string $name): bool
    {
        $originImagePath = $this->getPath($path) . DIRECTORY_SEPARATOR . $name;
        $thumbnailImagePath = $this->getPath($path, true) . DIRECTORY_SEPARATOR . $name;
        if ($hasOrigin = is_file($originImagePath))
            unlink($originImagePath);
        if ($hasThumbnail = is_file($thumbnailImagePath))
            unlink($thumbnailImagePath);
        return $hasOrigin || $hasThumbnail;
    }

    public function hasImage(): bool
    {
        return (bool)$this->image;
    }

}
