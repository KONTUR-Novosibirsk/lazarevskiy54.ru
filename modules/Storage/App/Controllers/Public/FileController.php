<?php

namespace Modules\Storage\App\Controllers\Public;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelStorage\App\Models\File;

class FileController extends Controller
{
    public function download(File $file): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download(
            storage_path('app' . DIRECTORY_SEPARATOR . $file->file),
            $file->name .'.'. $file->extension);
    }
}
