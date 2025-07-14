<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController; // keep all 'use' statements together
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\TenantDocumentController;
use App\Http\Controllers\TenantMessageController;
use App\Http\Controllers\Admin\MessageReplyController;




Route::get('/news', [NewsController::class, 'publicIndex'])->middleware('auth')->name('tenant.news');


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':Admin'])->group(function () {
});

Route::get('/offers', [\App\Http\Controllers\OfferController::class, 'index'])->name('offers.index');



Route::get('/directory', [App\Http\Controllers\BusinessController::class, 'index'])->name('directory');
Route::get('/directory/{business}', [App\Http\Controllers\BusinessController::class, 'show'])->name('directory.show');

Route::get('/news/{news}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::get('/offers/{offer}', [App\Http\Controllers\OfferController::class, 'show'])->name('offers.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/documents', [TenantDocumentController::class, 'index'])->name('tenant.documents.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [TenantMessageController::class, 'index'])->name('messages.index');
});

Route::post('/messages/{message}/reply', [TenantMessageController::class, 'reply'])->name('messages.reply');


Route::post('/admin/messages/{message}/reply', [MessageReplyController::class, 'store'])
    ->name('filament.admin.reply-to-message');


Route::get('/routes-debug-web', function () {
    return 'Web routes ARE LOADED';
});
require __DIR__.'/auth.php';
