<?php

namespace Modules\Gallery\App\Services;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Gallery\App\Models\Gallery;
use Modules\Gallery\App\Models\GalleryImage;
use Modules\Gallery\App\Requests\GalleryImage\SortImagesRequest;
use Modules\Gallery\App\Resources\GalleryResource;

class GalleryImageService
{
    public function sortImages(SortImagesRequest $request): bool
    {
        $data = $request->validated();
        $ids = collect($data['images'])->pluck('id');
        $images = GalleryImage::query()
            ->select('id', 'sort')
            ->whereIn('id', $ids->toArray())
            ->orderByRaw('FIELD(id, ' . implode(',', $ids->toArray()) . ')')->get();
        $sort = 1;
        foreach ($images as $image) {
            $image->sort = $sort;
            $image->save();
            $sort++;
        }
        return true;
    }
}
