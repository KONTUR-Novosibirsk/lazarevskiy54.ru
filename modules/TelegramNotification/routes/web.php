<?php

use Illuminate\Support\Facades\Route;
use Modules\TelegramNotification\App\Controllers\TelegramController;

Route::group(['prefix' => 'admin/telegram-notification', 'middleware' => ['web', 'dashboard', 'module:telegram-notification']], function () {
    Route::get('/index', [TelegramController::class, 'index'])->name('admin.tg.index');
    Route::get('/faq', [TelegramController::class, 'faq'])->name('admin.tg.faq');

    Route::group(['prefix' => 'account'], function () {
        Route::post('/store', [TelegramController::class, 'store'])->name('admin.tg.account.store');
        Route::post('/test/{account}', [TelegramController::class, 'sendTestMessage'])->name('admin.tg.account.test.message');
        Route::patch('/update/{account}', [TelegramController::class, 'update'])->name('admin.tg.account.update');
        Route::delete('/delete/{account}', [TelegramController::class, 'destroy'])->name('admin.tg.account.delete');
    });
});
