<?php

namespace Galtsevt\LaravelStorage\App\Traits;

use Galtsevt\LaravelStorage\App\Interfaces\Fileable;
use Galtsevt\LaravelStorage\App\Models\File;

trait HasFiles
{
    public static function bootHasFiles(): void
    {
        static::created(function (Fileable $model) {
            File::freeFilesAppendToModel($model);
        });
        static::deleting(function (Fileable $model) {
            $model->deleteFiles();
        });
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function getFilesByGroup(string $type): ?\Illuminate\Database\Eloquent\Collection
    {
        return $this->files?->where('group', $type);
    }

    public function deleteFiles(): void
    {
        foreach ($this->files as $file)
            $file->delete();
    }
}
