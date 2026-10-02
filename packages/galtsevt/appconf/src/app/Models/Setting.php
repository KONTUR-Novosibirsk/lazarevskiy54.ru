<?php

namespace Galtsevt\AppConf\app\Models;

use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Storage\App\Resources\ImageResource;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'value',
        'group',
    ];

    public static function saveData($data, $group = 'main'): bool|int
    {
        if (!$data) return false;
        foreach ($data as $key => $value)
            if ($value)
                $updateData[] = ['name' => $key, 'value' => $value, 'group' => $group];
            else {
                $deleteData[] = $key;
            }
        if (isset($deleteData)) {
            self::query()->where('group', $group)->whereIn('name', $deleteData)->delete();
        }

        return self::query()->upsert($updateData ?? [], ['name', 'group'], ['value']);
    }

    public static function getByGroup(string $group = 'main'): array
    {
        try {
            $settings = self::query()->where('group', $group)->get();
            foreach ($settings as $setting) {
                $resultSettings[$setting->name] = $setting->value;
            }
        } catch (\Exception $exception) {

        }

        return $resultSettings ?? [];
    }

    public static function getAll(): array
    {
        try {
            $settings = self::query()->get();
            foreach ($settings as $setting) {
                $resultSettings[$setting->group][$setting->name] = $setting->value;
            }
        } catch (\Exception $exception) {

        }
        return $resultSettings ?? [];
    }

    /**
     * Поиск изображения по классу
     *
     * @param string $modelClass
     * @return array|null
     */
    public static function image(string $modelClass): array|null
    {
        $images = Image::query()
            ->where('imageable_type', $modelClass)
            ->where('group', 'settings')
            ->get();

        if (!$images->count()) {
            return null;
        }

        $imagesArray = [];
        foreach ($images as $image) {
            $imagesArray[$image['prefix']] = ImageResource::make($image);
        }

        return $imagesArray;
    }
}
