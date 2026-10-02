<?php

namespace Galtsevt\LaravelStorage\App\Interfaces;

use Galtsevt\LaravelStorage\App\Models\Image;

interface Imageable
{
    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany;

    public function getImagesByGroup($type): ?\Illuminate\Database\Eloquent\Collection;

    public function loadImage($image, string $group): ?Image;

    public function deleteImages(): void;
}
