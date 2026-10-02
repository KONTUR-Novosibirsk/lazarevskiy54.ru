<?php

namespace Galtsevt\LaravelStorage\App\Interfaces;

interface Fileable
{
    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany;

    public function getFilesByGroup(string $type): ?\Illuminate\Database\Eloquent\Collection;

    public function deleteFiles(): void;
}
