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
    Route::post('/offers/{offer}/request', [SkillExchangeController::class, 'requestOffer'])->name('offers.request');
    Route::post('/needs/{need}/request', [SkillExchangeController::class, 'requestNeed'])->name('needs.request');
    Route::patch('/exchange-requests/{exchangeRequest}', [SkillExchangeController::class, 'updateExchange'])->name('exchange-requests.update');
});
