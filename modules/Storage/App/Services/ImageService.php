<?php

namespace Modules\Storage\App\Services;

use Exception;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Database\Eloquent\Relations\Relation;

class ImageService
{
    /**
     * @throws Exception
     */
    public function upload(array $data): Image
    {
        $imageableClass = Relation::getMorphedModel($data['imageable_type']) ?? $data['imageable_type'];
        try {
            $imageableModel = isset($data['imageable_id']) ? $imageableClass::find($data['imageable_id']) : new $imageableClass();
        } catch (\Exception $exception) {
            throw new Exception('Class or alias not found');
        }
        $image = $imageableModel->loadImage($data['image'], $data['group'], $data['prefix'] ?? null);
        return tap($image, function ($image) {
            $image->optimizeResolution()->save();
        });
    }

    public function sort(array $data): \Illuminate\Database\Eloquent\Collection|array
    {
        $ids = collect($data['images'])->pluck('id');
        $images = Image::query()
            ->select('id', 'sort')
            ->whereIn('id', $ids->toArray())
            ->orderByRaw('FIELD(id, ' . implode(',', $ids->toArray()) . ')')->get();
        $sort = 1;
        foreach ($images as $image) {
            $image->sort = $sort;
            $image->save();
            $sort++;
        }
        return $images;
    }

    public function crop(Image $image, array $coordinates): Image
    {
        return tap($image, function ($image) use ($coordinates) {
            $image->loadImageFromFile()->crop(
                width: $coordinates['width'],
                height: $coordinates['height'],
                offsetX: $coordinates['left'],
                offsetY: $coordinates['top'],
            )->save();
        });
    }
}
