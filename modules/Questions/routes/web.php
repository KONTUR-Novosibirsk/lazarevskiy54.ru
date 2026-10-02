<?php

use Illuminate\Support\Facades\Route;
use Modules\Questions\App\Controllers\Admin\QuestionController;

Route::group(['prefix' => 'admin/question', 'middleware' => ['web', 'dashboard', 'module:questions']], function () {
    Route::get('/', [QuestionController::class, 'index'])->name('admin.question.index');
    Route::post('/store', [QuestionController::class, 'store'])->name('admin.question.store');
    Route::patch('/update/{question}', [QuestionController::class, 'update'])->name('admin.question.update');
    Route::delete('/delete/{question}', [QuestionController::class, 'destroy'])->name('admin.question.delete');
    Route::patch('/status/change/{question}', [QuestionController::class, 'changeStatus'])->name('admin.question.status.change');
});

Route::group(['prefix' => 'questions', 'middleware' => ['web', 'module:questions']], function () {
    Route::get('/', [\Modules\Questions\App\Controllers\Public\QuestionController::class, 'index'])->name('question.index');
    Route::post('/store', [\Modules\Questions\App\Controllers\Public\QuestionController::class, 'store'])->name('question.store');
});
