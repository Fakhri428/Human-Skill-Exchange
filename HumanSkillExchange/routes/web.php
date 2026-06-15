<?php

use App\Http\Controllers\SkillExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SkillExchangeController::class, 'index'])->name('home');
Route::get('/market', [SkillExchangeController::class, 'index'])->name('market');
Route::get('/preview', [SkillExchangeController::class, 'index'])->name('preview');
Route::get('/offers/{offer}', [SkillExchangeController::class, 'showOffer'])->name('offers.show');
Route::get('/needs/{need}', [SkillExchangeController::class, 'showNeed'])->name('needs.show');
Route::get('/matches', [SkillExchangeController::class, 'matches'])->name('matches');

Route::view('/docs', 'api-docs')->name('docs');
Route::view('/api-docs', 'api-docs')->name('api.docs');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [SkillExchangeController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile/exchange', [SkillExchangeController::class, 'updateProfile'])->name('exchange.profile.update');
    Route::post('/skills', [SkillExchangeController::class, 'storeSkill'])->name('skills.store');
    Route::post('/offers', [SkillExchangeController::class, 'storeOffer'])->name('offers.store');
    Route::post('/needs', [SkillExchangeController::class, 'storeNeed'])->name('needs.store');
    Route::post('/portfolios', [SkillExchangeController::class, 'storePortfolio'])->name('portfolios.store');
    Route::delete('/portfolios/{portfolio}', [SkillExchangeController::class, 'destroyPortfolio'])->name('portfolios.destroy');
    Route::post('/offers/{offer}/request', [SkillExchangeController::class, 'requestOffer'])->name('offers.request');
    Route::post('/needs/{need}/request', [SkillExchangeController::class, 'requestNeed'])->name('needs.request');
    Route::patch('/exchange-requests/{exchangeRequest}', [SkillExchangeController::class, 'updateExchange'])->name('exchange-requests.update');
    
    // Admin
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('can:admin')->name('admin.dashboard');

    // Mentoring booking via web (simple)
    Route::post('/mentoring-rooms', [App\Http\Controllers\Api\MentoringRoomController::class, 'store'])->name('mentoring-rooms.store');
    Route::delete('/mentoring-rooms/{mentoringRoom}', [App\Http\Controllers\Api\MentoringRoomController::class, 'destroy'])->name('mentoring-rooms.destroy');

    // Web booking endpoint for users
    Route::post('/mentoring-bookings', [App\Http\Controllers\Api\MentoringBookingController::class, 'store'])->name('mentoring-bookings.store');

    // Admin actions for bookings and transactions
    Route::post('/admin/bookings/{booking}/approve', [App\Http\Controllers\AdminController::class, 'approveBooking'])->middleware('can:admin')->name('admin.bookings.approve');
    Route::post('/admin/bookings/{booking}/decline', [App\Http\Controllers\AdminController::class, 'declineBooking'])->middleware('can:admin')->name('admin.bookings.decline');
    Route::post('/admin/transactions/{transaction}/complete', [App\Http\Controllers\AdminController::class, 'completeTransaction'])->middleware('can:admin')->name('admin.transactions.complete');
});
