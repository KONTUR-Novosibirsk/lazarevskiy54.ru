<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounts\App\Controllers\Admin\AccountController as AdminAccountController;
use Modules\Accounts\App\Controllers\Public\{AccountController as PublicAccountController,
    AuthController,
    PasswordResetController};

Route::group(['middleware' => ['web', 'module:accounts']], function () {

    Route::group(['prefix' => 'account'], function () {

        Route::group(['controller' => AuthController::class], function () {
            Route::get('/register', 'register')->name('account.register');
            Route::get('/login', 'login')->name('account.login');
            Route::post('/store', 'store')->name('account.store');
            Route::post('/authenticate', 'authenticate')->name('account.authenticate');
        });

        Route::group([
            'prefix' => 'password',
            'controller' => PasswordResetController::class
        ], function () {
            Route::get('/reset', 'reset')->name('account.password.reset');
            Route::get('/edit', 'edit')->name('account.password.edit');
            Route::post('/send-reset-link', 'sendResetLink')->name('account.password.send-reset-link');
            Route::patch('/update', 'update')->name('account.password.update');
        });

        Route::group([
            'prefix' => 'me',
            'controller' => PublicAccountController::class,
            'middleware' => 'authentication'
        ], function () {
            Route::get('/', 'profile')->name('account.me');
            Route::get('/logout', 'logout')->name('account.me.logout');
            Route::get('/show', 'account')->name('account.me.show');
            Route::get('/history', 'history')->name('account.me.history');
            Route::patch('/update', 'update')->name('account.me.update');
        });
    });

    Route::group([
        'prefix' => 'admin/accounts',
        'controller' => AdminAccountController::class,
        'middleware' => 'dashboard'
    ], function () {
        Route::get('/', 'index')->name('admin.accounts.index');
        Route::patch('/toggle-confirmed/{account}', 'toggleConfirmed')->name('admin.accounts.toggle-confirmed');
        Route::delete('/destroy/{account}', 'destroy')->name('admin.accounts.destroy');
    });
});
