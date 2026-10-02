<?php

use Illuminate\Support\Facades\Route;
use Modules\News\App\Controllers\Admin\NewsController;

Route::group(['prefix' => 'admin/news', 'middleware' => ['module:news']], function () {
    Route::group(['middleware' => ['web', 'dashboard']], function () {
        Route::get('/index', [NewsController::class, 'index'])->name('admin.news.index');
        Route::get('/show/{news}', [NewsController::class, 'show'])->name('admin.news.show');
        Route::get('/images/{news}', [NewsController::class, 'getImages'])->name('admin.news.images');
        Route::get('/store', [NewsController::class, 'store'])->name('admin.news.store');
        Route::get('/edit/{news}', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::patch('/update/{news}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::patch('/saveAsDraft/{news}', [NewsController::class, 'saveAsDraft'])->name('admin.news.saveDraft');
        Route::delete('/delete/{news}', [NewsController::class, 'destroy'])->name('admin.news.delete');
        Route::post('/{news}/update-sort', [NewsController::class, 'updateSort'])->name('admin.news.updateSort');
        Route::post('/getNewsSort', [NewsController::class, 'getNewsSort'])->name('admin.news.getNewsSort');
    });
});
Route::group(['prefix' => 'news', 'middleware' => ['web', 'module:news']], function () {
    Route::get('/', [\Modules\News\App\Controllers\Public\NewsController::class, 'index'])->name('news.index');
    Route::get('/{alias}', [\Modules\News\App\Controllers\Public\NewsController::class, 'show'])->name('news.show');
});
