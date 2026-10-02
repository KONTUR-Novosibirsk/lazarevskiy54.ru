<?php

use Illuminate\Support\Facades\Route;
use Modules\InfoBlocks\App\Controllers\Admin\InfoBlockCategoryController;
use Modules\InfoBlocks\App\Controllers\Admin\InfoBlockController;
use Modules\InfoBlocks\App\Controllers\Admin\InfoBlockElementController;

Route::group(['prefix' => 'admin/iblock', 'middleware' => ['web', 'dashboard', 'module:iblock']], function () {
    Route::get('/index', [InfoBlockController::class, 'index'])->name('admin.iblock.index');
    Route::get('/create', [InfoBlockController::class, 'create'])->name('admin.iblock.create');
    Route::post('/store', [InfoBlockController::class, 'store'])->name('admin.iblock.store');
    Route::get('/edit/{infoBlock}', [InfoBlockController::class, 'edit'])->name('admin.iblock.edit');
    Route::patch('/update/{infoBlock}', [InfoBlockController::class, 'update'])->name('admin.iblock.update');
    Route::patch('/updateForUser/{infoBlock}', [InfoBlockController::class, 'updateForUser'])->name('admin.iblock.updateForUser');
    Route::delete('/delete/{infoBlock}', [InfoBlockController::class, 'destroy'])->name('admin.iblock.delete');
    Route::group(['prefix' => 'element'], function () {
        Route::post('/sort', [InfoBlockElementController::class, 'sort'])->name('admin.iblock.element.sort');
        Route::get('/index/{infoBlock}', [InfoBlockElementController::class, 'index'])->name('admin.iblock.element.index');
        Route::get('/create/{infoBlock}', [InfoBlockElementController::class, 'create'])->name('admin.iblock.element.create');
        Route::post('/store/{infoBlock}', [InfoBlockElementController::class, 'store'])->name('admin.iblock.element.store');
        Route::get('/edit/{infoBlockElement}', [InfoBlockElementController::class, 'edit'])->name('admin.iblock.element.edit');
        Route::patch('/update/{infoBlockElement}', [InfoBlockElementController::class, 'update'])->name('admin.iblock.element.update');
        Route::delete('/delete/{infoBlockElement}', [InfoBlockElementController::class, 'destroy'])->name('admin.iblock.element.delete');
        Route::post('/uploadPreview/{infoBlockElement?}', [InfoBlockElementController::class, 'uploadPreview'])->name('admin.iblock.element.uploadPreview');
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/show/{infoBlockCategory}', [InfoBlockCategoryController::class, 'show'])->name('admin.iblock.category.show');
        Route::post('/store', [InfoBlockCategoryController::class, 'store'])->name('admin.iblock.category.store');
        Route::patch('/update/{category}', [InfoBlockCategoryController::class, 'update'])->name('admin.iblock.category.update');
        Route::delete('/delete/{category}', [InfoBlockCategoryController::class, 'destroy'])->name('admin.iblock.category.delete');
    });
});
