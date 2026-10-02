<?php

namespace Modules\Gallery\App\Controllers\Admin;

use Modules\Gallery\App\Models\{Gallery, GalleryImage};
use Modules\Gallery\App\Requests\GalleryImage\{SortImagesRequest, UpdateRequest, UploadImagesRequest};
use Modules\Gallery\App\Resources\GalleryImageResource;
use Modules\Gallery\App\Services\GalleryImageService;

class GalleryImageController extends \App\Http\Controllers\Controller
{
    public function uploadImage(UploadImagesRequest $request, Gallery $gallery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = $request->validated();
        foreach ($data['images'] as $image) {
            $galleryImage = new GalleryImage();
            $galleryImage->gallery_id = $gallery->id;
            $galleryImage->loadImage($image, 'main')->save();
            $galleryImage->save();
        }
        return GalleryImageResource::collection($gallery->images()->get());
    }

    public function update(GalleryImage $galleryImage, UpdateRequest $request): GalleryImageResource
    {
        return new GalleryImageResource(tap($galleryImage, fn($image) => $image->update($request->validated())));
    }

    public function sortImages(SortImagesRequest $request, GalleryImageService $galleryImageService): bool
    {
        return $galleryImageService->sortImages($request);
    }

    public function destroy(GalleryImage $galleryImage): bool
    {
        $galleryImage->delete();
        return true;
    }
}
