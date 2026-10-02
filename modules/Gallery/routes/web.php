<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\App\Controllers\Admin\GalleryController;
use Modules\Gallery\App\Controllers\Admin\GalleryImageController;

Route::group(['middleware' => ['web', 'dashboard', 'module:gallery'], 'prefix' => 'admin/gallery'], function () {
    Route::get('/', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::post('/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::get('/edit/{gallery}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::patch('/update/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::patch('/updateCover/{gallery}', [GalleryController::class, 'updateCover'])->name('admin.gallery.updateCover');
    Route::delete('/delete/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.delete');
    Route::group(['prefix' => 'image'], function () {
        Route::post('/upload/{gallery}', [GalleryImageController::class, 'uploadImage'])->name('admin.gallery.image.upload');
        Route::post('/sort', [GalleryImageController::class, 'sortImages'])->name('admin.gallery.image.sort');
        Route::patch('/update/{galleryImage}', [GalleryImageController::class, 'update'])->name('admin.gallery.image.update');
        Route::delete('/delete/{galleryImage}', [GalleryImageController::class, 'destroy'])->name('admin.gallery.image.delete');
    });
});

Route::group(['middleware' => ['web', 'module:gallery'], 'prefix' => 'gallery'], function () {
    Route::get('/', [\Modules\Gallery\App\Controllers\GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/{alias}', [\Modules\Gallery\App\Controllers\GalleryController::class, 'show'])->name('gallery.show');
});
