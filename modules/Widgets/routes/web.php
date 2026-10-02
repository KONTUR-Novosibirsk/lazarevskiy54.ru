<?php

use Illuminate\Support\Facades\Route;
use Modules\Widgets\App\Controllers\NoteController;

Route::group(['prefix' => 'admin/widgets', 'middleware' => ['web', 'dashboard', 'module:widgets']], function () {
    Route::group(['prefix' => 'note'], function () {
        Route::get('/', [NoteController::class, 'index'])->name('admin.widget.note.index');
        Route::post('/store', [NoteController::class, 'store'])->name('admin.widget.note.store');
        Route::delete('/delete/{note}', [NoteController::class, 'destroy'])->name('admin.widget.note.delete');
        Route::delete('/deleteWithRefresh/{note}', [NoteController::class, 'destroyWithRefresh'])->name('admin.widget.note.delete.refresh');
    });
});
