<?php

namespace Modules\Storage\App\Controllers\Admin;

use App\Http\Controllers\Controller;

use Galtsevt\LaravelStorage\App\Models\File;
use Modules\Storage\App\Requests\File\UploadFileRequest;
use Modules\Storage\App\Resources\FileResource;

class FileController extends Controller
{
    public function upload(UploadFileRequest $request): FileResource
    {
        $data = $request->validated();
        $file = new File($data);
        $file->loadFile($data['file'])->group($data['group'])->save();
        return new FileResource($file);
    }

    public function destroy(File $file): \Illuminate\Http\JsonResponse
    {
        return response()->json($file->delete());
    }
}
