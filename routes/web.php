<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\TenantDocumentController;
use App\Http\Controllers\TenantMessageController;
use App\Http\Controllers\Admin\MessageReplyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\BusinessController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', [NewsController::class, 'publicIndex'])->middleware('auth')->name('tenant.news');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    Route::post('/messages/{id}/hide', [\App\Http\Controllers\TenantMessageController::class, 'hide'])
    ->name('tenant.messages.hide');


Route::get('/polls', [\App\Http\Controllers\TenantPollController::class, 'index'])->name('tenant.polls.index');
Route::post('/polls/{poll}/vote', [\App\Http\Controllers\TenantPollController::class, 'vote'])->name('tenant.polls.vote');


    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tenant documents
    Route::get('/documents', [TenantDocumentController::class, 'index'])->name('tenant.documents.index');

    // Tenant messages (all routes grouped here)
    Route::get('/messages', [TenantMessageController::class, 'index'])->name('tenant.messages.index');
    Route::get('/messages/create', [TenantMessageController::class, 'create'])->name('tenant.messages.create');
    Route::post('/messages', [TenantMessageController::class, 'store'])->name('tenant.messages.store');
    Route::get('/messages/{id}', [TenantMessageController::class, 'show'])->name('tenant.messages.show');
    Route::post('/messages/{message}/reply', [TenantMessageController::class, 'reply'])->name('messages.reply');

});

// Admin routes with role middleware
Route::middleware(['auth', RoleMiddleware::class . ':Admin'])->group(function () {
    // Admin message replies
    Route::post('/admin/messages/{message}/reply', [MessageReplyController::class, 'store'])
        ->name('filament.admin.reply-to-message');
});

// Offers
Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');

// Business directory
Route::get('/directory', [BusinessController::class, 'index'])->name('directory');
Route::get('/directory/{business}', [BusinessController::class, 'show'])->name('directory.show');

// News item
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Debug route to confirm web routes load
Route::get('/routes-debug-web', function () {
    return 'Web routes ARE LOADED';
});


Route::middleware(['auth'])->get('/suppliers', [\App\Http\Controllers\RecommendedSupplierController::class, 'index'])->name('tenant.suppliers');


require __DIR__.'/auth.php';
