<?php

use Illuminate\Support\Facades\Route;
use Modules\Feedback\App\Controllers\Admin\FeedbackController;

Route::group(['middleware' => ['web', 'dashboard', 'module:feedback'], 'prefix' => 'admin/feedback'], function () {
    Route::get('/show/{name}', [FeedbackController::class, 'show'])->name('admin.feedback.show');
    Route::patch('/changeStatus/{feedback}', [FeedbackController::class, 'changeStatus'])->name('admin.feedback.changeStatus');
    Route::delete('/delete/{feedback}', [FeedbackController::class, 'destroy'])->name('admin.feedback.delete');
    Route::delete('/massDelete', [FeedbackController::class, 'massDestroy'])->name('admin.feedback.massDelete');
});
Route::group(['middleware' => ['web', 'module:feedback'], 'prefix' => 'feedback'], function () {
    Route::post('/store/{name}', [\Modules\Feedback\App\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
});
