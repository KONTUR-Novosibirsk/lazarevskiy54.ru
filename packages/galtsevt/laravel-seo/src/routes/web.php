<?php

use Galtsevt\LaravelSeo\App\Controllers\TemplateSeoController;
use Galtsevt\LaravelSeo\App\Controllers\UrlSeoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'dashboard', 'module:seo'], 'prefix' => 'admin/seo'], function () {
    Route::get('/', [UrlSeoController::class, 'index'])->name('admin.seo.index');
    Route::post('/store', [UrlSeoController::class, 'store'])->name('admin.url_seo.store');
    Route::patch('/update/{urlSeo}', [UrlSeoController::class, 'update'])->name('admin.url_seo.update');
    Route::delete('/delete/{urlSeo}', [UrlSeoController::class, 'destroy'])->name('admin.url_seo.delete');
    Route::group(['prefix' => 'template'], function () {
        Route::get('/', [TemplateSeoController::class, 'index'])->name('admin.seo.template.index');
        Route::post('/updateOrCreate', [TemplateSeoController::class, 'updateOrCreate'])->name('admin.seo.template.updateOrCreate');
        Route::delete('/delete/{seo}', [TemplateSeoController::class, 'destroy'])->name('admin.seo.template.delete');
    });
});

Route::group(['middleware' => ['module:seo']], function () {
    Route::get('/sitemap.xml', [\Galtsevt\LaravelSeo\App\Controllers\SitemapController::class, 'index']);
});
