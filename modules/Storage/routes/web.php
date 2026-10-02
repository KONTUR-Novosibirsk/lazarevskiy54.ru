<?php

use Illuminate\Support\Facades\Route;
use Modules\Storage\App\Controllers\Admin\FileController;
use Modules\Storage\App\Controllers\Public\FileController as PublicFileController;
use Modules\Storage\App\Controllers\Admin\ImageController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/storage/images'], function () {
    Route::post('/upload', [ImageController::class, 'upload'])->name('admin.storage.image.upload');
    Route::post('/sort', [ImageController::class, 'sort'])->name('admin.storage.images.sort');
    Route::post('/crop/{image}', [ImageController::class, 'crop'])->name('admin.storage.image.crop');
    Route::delete('/delete/{image}', [ImageController::class, 'destroy'])->name('admin.storage.image.delete');
});

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/storage/file'], function () {
    Route::post('/upload', [FileController::class, 'upload'])->name('admin.storage.file.upload');
    Route::delete('/delete/{file}', [FileController::class, 'destroy'])->name('admin.storage.file.delete');
});

Route::group(['middleware' => ['web'], 'prefix' => 'file'], function () {
    Route::get('/download/{file}', [PublicFileController::class, 'download'])->name('file.download');
});

