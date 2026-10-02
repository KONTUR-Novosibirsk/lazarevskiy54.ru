<?php

namespace Galtsevt\LaravelStorage\App\Models;

use Galtsevt\LaravelStorage\App\Interfaces\Fileable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected ?UploadedFile $upload_file = null;

    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'name',
        'group',
    ];

    protected static function booted(): void
    {
        static::saving(function (File $file) {
            if ($file->upload_file) {
                $file->extension = $file->upload_file->extension();
                $file->size = $file->upload_file->getSize();
                $file->file = $file->upload_file->store($file->getStorePath());
                $namePath = explode('.', $file->upload_file->getClientOriginalName());
                $file->name = current($namePath);
                $file->user_id = Auth::id() ?? null;
            }
        });
        static::deleting(function (File $file) {
            Storage::delete($file->file);
        });
    }

    public function loadFile($file, Model $parentModel = null): static
    {
        $this->upload_file = $file;
        $this->group = 'main';
        if ($parentModel) {
            $this->fileable_type = get_class($parentModel);
            $this->fileable_id = $parentModel->id ?? null;
        }
        return $this;
    }

    public function group(string $group): static
    {
        $this->group = $group;
        return $this;
    }

    public function getStorePath(): string
    {
        $modelPath = explode('\\', $this->fileable_type);
        return DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . strtolower(end($modelPath));
    }

    function getFileSizeForHuman(): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $this->size > 1024; $i++) $this->size /= 1024;
        return round($this->size, 2) . ' ' . $units[$i];
    }

    public static function getFreeFiles($model, $group = null): \Illuminate\Database\Eloquent\Collection|array
    {
        $images = File::query()->whereNull('fileable_id')
            ->where([['fileable_type', get_class($model)], ['user_id', auth()->id()]]);
        if ($group) $images->where('group', $group);
        return $images->get();
    }

    public static function freeFilesAppendToModel(Fileable $model): void
    {
        foreach (self::getFreeFiles($model) as $image) {
            $image->fileable_id = $model->id;
            $image->save();
        }
    }
}
