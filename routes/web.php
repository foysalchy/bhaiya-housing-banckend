<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Content;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobApplicationController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

//password reset
Route::get('password/reset', [HomeController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [HomeController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [HomeController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [HomeController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    // user management routes
    Route::get('/admin/users', [HomeController::class, 'userIndex'])->name('admin.users.index');
    Route::get('/admin/users/create', [HomeController::class, 'userForm'])->name('admin.users.create');
    Route::get('/admin/users/{id}', [HomeController::class, 'userForm'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [HomeController::class, 'userForm'])->name('admin.users.edit');
    Route::post('/admin/users/store', [HomeController::class, 'adminStoreUser'])->name('admin.users.store');
    Route::put('/admin/users/{id}/update', [HomeController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [HomeController::class, 'userDestroy'])->name('admin.users.destroy');
     Route::get('/change-password', [HomeController::class, 'changePasswordView'])->name('user.password.change');
    Route::post('/change-password', [HomeController::class, 'updatePasswordLoggedIn'])->name('user.password.update_logged_in');

    Route::get('/contents/{type}', [ContentController::class, 'index'])->name('content.index');
    Route::get('/contents/{type}/create', [ContentController::class, 'create'])->name('content.create');
    Route::get('/contents/{type}/edit/{id}', [ContentController::class, 'edit'])->name('content.edit');
    Route::post('/contents/store', [ContentController::class, 'store'])->name('content.store');
    Route::post('/contents/update', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/contents/destroy/{type}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::get('contacts',              [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/{id}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('contacts/block', [ContactController::class, 'blockIp'])->name('contacts.block');
    Route::post('contacts/unblock', [ContactController::class, 'unblockIp'])->name('contacts.unblock');
    Route::post('contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    Route::post('contacts/bulk-block', [ContactController::class, 'bulkBlock'])->name('contacts.bulk-block');
    Route::post('contacts/export-csv', [ContactController::class, 'exportCsv'])->name('contacts.export-csv');
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('job.applications.index');
    Route::delete('/job-applications/{id}', [JobApplicationController::class, 'destroy'])->name('job.applications.destroy');
     Route::post('/contents/reorder', [App\Http\Controllers\ContentController::class, 'reorder'])->name('content.reorder');
});


Route::get('/', [WebController::class, 'index'])->name('front.home');
Route::get('/about', [WebController::class, 'about'])->name('front.about');
Route::get('/career', [WebController::class, 'career'])->name('career');
Route::get('/career/{slug}', [WebController::class, 'jobDetail'])->name('job.details');
Route::post('/career/apply', [WebController::class, 'applyJob'])->name('job.apply');
Route::get('/projects', [WebController::class, 'projects'])->name('projects');
Route::get('/projects/{name}', [WebController::class, 'showProject'])->name('projects.show');
Route::get('/event', [WebController::class, 'events'])->name('events');
Route::get('/page/{slug}', [WebController::class, 'page'])->name('page.show');

Route::get('/customer-contact',        [WebController::class, 'customerContact'])->name('contact');
Route::get('/office-locations',        [WebController::class, 'officeLocations'])->name('office.locations');
Route::post('/customer-contact/store', [WebController::class, 'customerContactStore'])->name('contact.store')->middleware(\App\Http\Middleware\CheckBlockedIp::class);
Route::post('/contact-inquiry', [WebController::class, 'contactInquiry'])->name('contact.inquiry')->middleware(\App\Http\Middleware\CheckBlockedIp::class);
Route::get('/landowner-contact',        [WebController::class, 'landowner'])->name('landowner');
Route::post('/landowner-contact/store', [WebController::class, 'landownerStore'])->name('landowner.store')->middleware(\App\Http\Middleware\CheckBlockedIp::class);
Route::get('/concerns', [WebController::class, 'concerns'])->name('concerns');
Route::get('/news/{slug}',   [WebController::class, 'show'])->name('news.show');
Route::get('/event/{slug}', [WebController::class, 'show'])->name('events.show');
Route::get('/blog', [WebController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [WebController::class, 'blogDetail'])->name('blog.details');

Route::get('/sitemap.xml', [WebController::class, 'sitemap']);


