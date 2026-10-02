<?php

use Illuminate\Support\Facades\Route;
use Modules\Reviews\App\Controllers\Admin\ReviewController;

Route::group(['prefix' => 'admin/review', 'middleware' => ['web', 'dashboard', 'module:reviews']], function () {
    Route::get('/', [ReviewController::class, 'index'])->name('admin.review.index');
    Route::post('/store', [ReviewController::class, 'store'])->name('admin.review.store');
    Route::patch('/update/{review}', [ReviewController::class, 'update'])->name('admin.review.update');
    Route::delete('/delete/{review}', [ReviewController::class, 'destroy'])->name('admin.review.delete');
    Route::patch('/status/change/{review}', [ReviewController::class, 'changeStatus'])->name('admin.review.status.change');
    Route::post('/{review}/update-sort', [ReviewController::class, 'updateSort'])->name('admin.review.updateSort');
    Route::post('/getReviewSort', [ReviewController::class, 'getReviewSort'])->name('admin.review.getReviewSort');
});

Route::group(['prefix' => 'reviews', 'middleware' => ['web', 'module:reviews']], function () {
    Route::get('/', [\Modules\Reviews\App\Controllers\Public\ReviewController::class, 'index'])->name('review.index');
    Route::post('/store', [\Modules\Reviews\App\Controllers\Public\ReviewController::class, 'store'])->name('review.store');
});
