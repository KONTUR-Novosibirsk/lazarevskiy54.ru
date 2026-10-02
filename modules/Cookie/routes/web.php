<?php

use Illuminate\Support\Facades\Route;
use Modules\Cookie\App\Controllers\Public\CookieController;
use Modules\Cookie\App\Controllers\Admin\IndexController;

Route::group([
    'prefix' => 'admin/cookie',
    'middleware' => ['web', 'dashboard', 'module:cookie']],
    function () {
        Route::get('/index', [IndexController::class, 'index'])
            ->name('admin.cookie.index');
    });


Route::group([
    'prefix' => 'cookie',
    'middleware' => ['web']
], function () {
    Route::post('/accept', [CookieController::class, 'accept'])
        ->name('cookie.accept');
});
