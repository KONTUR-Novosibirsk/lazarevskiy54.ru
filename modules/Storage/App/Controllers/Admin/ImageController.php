<?php

namespace Modules\Storage\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Storage\App\Requests\Image\{ResizeImageRequest, SortImagesRequest, UploadImageRequest};
use Modules\Storage\App\Resources\ImageResource;
use Modules\Storage\App\Services\ImageService;

class ImageController extends Controller
{
    public function upload(UploadImageRequest $request, ImageService $imageService): ImageResource
    {
        return new ImageResource($imageService->upload($request->validated()));
    }

    public function crop(Image $image, ResizeImageRequest $request, ImageService $imageService): ImageResource
    {
        return new ImageResource($imageService->crop($image, $request->validated()));
    }

    public function sort(SortImagesRequest $request, ImageService $imageService): AnonymousResourceCollection
    {
        return ImageResource::collection($imageService->sort($request->validated()));
    }

    public function destroy(Image $image): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $image->delete(),
        ]);
    }
}
