<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/sale', 'middleware' => ['module:sale']], function () {
    Route::group(['middleware' => ['web', 'dashboard']], function () {
        Route::get('/index', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'index'])->name('admin.sale.index');
        Route::get('/show/{sale}', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'show'])->name('admin.sale.show');
        Route::get('/create', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'create'])->name('admin.sale.create');
        Route::post('/store', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'store'])->name('admin.sale.store');
        Route::get('/edit/{sale}', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'edit'])->name('admin.sale.edit');
        Route::patch('/update/{sale}', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'update'])->name('admin.sale.update');
        Route::delete('/delete/{sale}', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'destroy'])->name('admin.sale.delete');
        Route::post('/uploadPreview/{sale?}', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'uploadPreview'])->name('admin.sale.uploadPreview');
        Route::post('/{sale}/update-sort', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'updateSort'])->name('admin.sale.updateSort');
        Route::post('/getSaleSort', [\Modules\Sale\App\Controllers\Admin\SaleController::class, 'getSaleSort'])->name('admin.sale.getSaleSort');
    });
});

Route::group(['prefix' => 'sale', 'middleware' => ['web', 'module:sale']], function () {
    Route::get('/', [\Modules\Sale\App\Controllers\Public\SaleController::class, 'index'])->name('sale.index');
    Route::get('/{alias}', [\Modules\Sale\App\Controllers\Public\SaleController::class, 'show'])->name('sale.show');
});
