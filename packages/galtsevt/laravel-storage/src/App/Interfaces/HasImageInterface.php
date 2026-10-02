<?php

namespace Galtsevt\LaravelStorage\App\Interfaces;

use Galtsevt\LaravelStorage\App\Services\ImageStorage;

interface HasImageInterface
{
    public function loadImage($image, int $quality = 100): static;

    public function imageStorage(): ImageStorage;

    public function getImageAttribute(): string;

    public function imageHasThumbnail(): bool;

    public function getFull(): string;

    public function getPreview(): ?string;

    public function deleteImage(): bool;
}
