<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\App\Http\Admin\Controllers\ServiceController;

Route::prefix('admin/services')
    ->middleware(['web', 'dashboard', 'module:services'])
    ->name('admin.services.')
    ->group(function () {

        Route::get('/',                 [ServiceController::class, 'show'])->name('index');
        Route::get('/create',           [ServiceController::class, 'create'])->name('create');

        Route::get('/{service}',        [ServiceController::class, 'show'])->name('show')->where('service', '[0-9]+');
        Route::get('/{service}/create', [ServiceController::class, 'create'])->name('create.child')->where('service', '[0-9]+');
        Route::get('/{service}/edit',   [ServiceController::class, 'edit'])->name('edit');

        Route::post('/',                [ServiceController::class, 'store'])->name('store');
        Route::put('/{service}',        [ServiceController::class, 'update'])->name('update');
        Route::patch('/{service}',      [ServiceController::class, 'updatePartial'])->name('updatePartial');
        Route::delete('/{service}',     [ServiceController::class, 'destroy'])->name('delete');
});
