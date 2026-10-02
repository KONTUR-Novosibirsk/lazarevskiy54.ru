<?php

use Illuminate\Support\Facades\Route;
use Modules\Pages\App\Controllers\Admin\PageController;

Route::group(['prefix' => 'admin/page', 'middleware' => ['module:page']], function () {
    Route::group(['middleware' => ['web', 'dashboard']], function () {
        Route::get('/index', [PageController::class, 'index'])->name('admin.page.index');
        Route::get('/show/{page}', [PageController::class, 'show'])->name('admin.page.show');
        Route::get('/create', [PageController::class, 'create'])->name('admin.page.create');
        Route::post('/store', [PageController::class, 'store'])->name('admin.page.store');
        Route::get('/edit/{page}', [PageController::class, 'edit'])->name('admin.page.edit');
        Route::patch('/update/{page}', [PageController::class, 'update'])->name('admin.page.update');
        Route::delete('/delete/{page}', [PageController::class, 'destroy'])->name('admin.page.delete');
        Route::post('/uploadPreview/{page?}', [PageController::class, 'uploadPreview'])->name('admin.page.uploadPreview');
    });
});

Route::group(['prefix' => 'page', 'middleware' => ['web', 'module:page']], function () {
    Route::get('/{page:alias}', [\Modules\Pages\App\Controllers\PageController::class, 'show'])->name('page.show');
});
