<?php

use Illuminate\Support\Facades\Route;
use Kontur\Dashboard\App\Controllers\CommandController;
use Kontur\Dashboard\App\Controllers\ModulesController;
use Kontur\Dashboard\App\Controllers\WidgetController;

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function () {
    Route::group(['middleware' => ['dashboard']], function () {
        Route::get('/', [\Kontur\Dashboard\App\Controllers\IndexController::class, 'index'])->name('admin.index');
        Route::post('/logout', \Kontur\Dashboard\App\Controllers\Auth\LogoutController::class)->name('admin.logout');
        Route::group(['middleware' => ['devAdmin'], 'prefix' => 'modules'], function () {
            Route::get('/', [ModulesController::class, 'index'])->name('admin.modules');
            Route::post('/update', [ModulesController::class, 'update'])->name('admin.modules.update');
        });
        Route::group(['prefix' => 'widget'], function () {
            Route::get('/', [WidgetController::class, 'index'])->name('admin.widget');
            Route::post('/update', [WidgetController::class, 'update'])->name('admin.widget.update');
        });
        Route::post('/command/call', CommandController::class)->name('admin.command.call');
        Route::patch('/user/changePerPage', [\Kontur\Dashboard\App\Controllers\UserController::class, 'perPage'])->name('admin.user.changePerPage');
        Route::post('/saveEnv', [\Kontur\Dashboard\App\Controllers\EnvController::class, 'saveEnv'])->name('admin.env.save');
    });
    Route::group(['middleware' => ['guest', 'inertia']], function () {
        Route::get('/login', \Kontur\Dashboard\App\Controllers\Auth\LoginController::class)->name('admin.login');
        Route::post('/auth', \Kontur\Dashboard\App\Controllers\Auth\AuthController::class)->name('admin.auth');
    });
});

Route::get('/google/recaptcha-info', [\Kontur\Dashboard\App\Controllers\RecaptchaController::class, 'info'])->name('google.recaptcha.info');


