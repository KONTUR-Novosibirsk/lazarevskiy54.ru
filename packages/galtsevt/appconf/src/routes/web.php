<?php

use Galtsevt\AppConf\app\Http\AppearanceController;
use Galtsevt\AppConf\app\Http\ConfigController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('admin_settings.middleware'), 'prefix' => 'admin'], function () {
    Route::post('/settings/appearance', AppearanceController::class)->name('admin.settings.appearance');
    Route::get('/settings/{name?}', [ConfigController::class, 'index'])->name('admin.settings');
    Route::post('/settings/{name?}', [ConfigController::class, 'save'])->name('admin.settings.save');
});
