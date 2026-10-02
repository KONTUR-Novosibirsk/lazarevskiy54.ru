<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\App\Controllers\MenuCategoryController;
use Modules\Menu\App\Controllers\MenuController;

Route::group(['prefix' => 'admin/menu', 'middleware' => ['web', 'dashboard', 'module:menu']], function () {
    Route::get('/', [MenuCategoryController::class, 'index'])->name('admin.menuBuilder.index');
    Route::post('/store', [MenuController::class, 'storeLink'])->name('admin.menu.storeLink');
    Route::patch('/update/{menuItem}', [MenuController::class, 'updateLink'])->name('admin.menu.updateLink');
    Route::patch('/updateMenuItems/{menuCategory}', [MenuController::class, 'updateMenuItems'])->name('admin.menu.updateMenuItems');
    Route::delete('/deleteMenuItem/{menuItem}', [MenuController::class, 'destroy'])->name('admin.menu.deleteMenuItem');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/show/{menuCategory}', [MenuCategoryController::class, 'show'])->name('admin.menu.show');
        Route::post('/store', [MenuCategoryController::class, 'store'])->name('admin.menu.store');
        Route::patch('/update/{menuCategory}', [MenuCategoryController::class, 'update'])->name('admin.menu.update');
        Route::delete('/delete/{menuCategory}', [MenuCategoryController::class, 'destroy'])->name('admin.menu.delete');
    });
});
