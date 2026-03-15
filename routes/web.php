<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Content;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/cc', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "✅ All caches cleared!";
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/contents/{type}', [App\Http\Controllers\ContentController::class, 'index'])->name('content.index');
    Route::get('/contents/{type}/create', [App\Http\Controllers\ContentController::class, 'create'])->name('content.create');
    Route::get('/contents/{type}/edit/{id}', [App\Http\Controllers\ContentController::class, 'edit'])->name('content.edit');
    Route::post('/contents/store', [App\Http\Controllers\ContentController::class, 'store'])->name('content.store');
    Route::post('/contents/update', [App\Http\Controllers\ContentController::class, 'update'])->name('content.update');
    Route::delete('/contents/destroy/{type}/{id}', [App\Http\Controllers\ContentController::class, 'destroy'])->name('content.destroy');

});


Route::get('/', [WebController::class, 'index'])->name('front.home');


