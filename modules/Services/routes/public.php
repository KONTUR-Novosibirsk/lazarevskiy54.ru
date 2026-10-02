<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\App\Http\Public\Controllers\ServiceController;

Route::prefix('services')
    ->middleware(['web', 'module:services'])
    ->name('services.')
    ->group(function () {

        Route::get('/',          [ServiceController::class, 'index'])->name('index');
        Route::get('/{path?}',   [ServiceController::class, 'show'])->where('path', '.*')->name('show');
});
