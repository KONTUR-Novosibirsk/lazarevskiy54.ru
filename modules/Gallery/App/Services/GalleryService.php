<?php

namespace Modules\Gallery\App\Services;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Gallery\App\Models\Gallery;
use Modules\Gallery\App\Resources\GalleryResource;

class GalleryService
{
    public function update(FormRequest $request, Gallery $gallery): GalleryResource
    {
        $data = $request->validated();
        $gallery->update($data);
        return new GalleryResource($gallery);
    }
}
