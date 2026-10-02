<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\App\Controllers\Admin\SlideController;
use Modules\Slider\App\Controllers\Admin\SliderController;

Route::group(['prefix' => 'admin/slider', 'middleware' => ['web', 'dashboard', 'module:slider']], function () {
    Route::get('/', [SliderController::class, 'index'])->name('admin.slider.index');
    Route::get('/show/{slider}', [SliderController::class, 'show'])->name('admin.slider.show');
    Route::post('/store', [SliderController::class, 'store'])->name('admin.slider.store');
    Route::patch('/update/{slider}', [SliderController::class, 'update'])->name('admin.slider.update');
    Route::delete('/delete/{slider}', [SliderController::class, 'destroy'])->name('admin.slider.delete');
    Route::group(['prefix' => 'slide'], function () {
        Route::get('/create/{slider}', [SlideController::class, 'create'])->name('admin.slide.create');
        Route::post('/store/{slider}', [SlideController::class, 'store'])->name('admin.slide.store');
        Route::get('/edit/{slide}', [SlideController::class, 'edit'])->name('admin.slide.edit');
        Route::patch('/update/{slide}', [SlideController::class, 'update'])->name('admin.slide.update');
        Route::post('/uploadPreview/{slide?}', [SlideController::class, 'uploadPreview'])->name('admin.slide.uploadPreview');
        Route::delete('/delete/{slide}', [SlideController::class, 'destroy'])->name('admin.slide.delete');
        Route::patch('/sort', [SlideController::class, 'sort'])->name('admin.slide.sort');
        Route::post('/{slide}/update-sort', [SlideController::class, 'updateSort'])->name('admin.slide.updateSort');
    });
});
