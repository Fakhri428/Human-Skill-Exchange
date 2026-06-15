<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ExchangeProgressController;
use App\Http\Controllers\Api\ExchangeRequestController;
use App\Http\Controllers\Api\ExchangeTypeController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\NeedController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReputationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::get('/plans', [PlanController::class, 'index']);
Route::get('/exchange-types', [ExchangeTypeController::class, 'index']);
Route::get('/exchange_types', [ExchangeTypeController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthApiController::class, 'me']);
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::get('/subscription', [PlanController::class, 'current']);
    Route::post('/subscription', [PlanController::class, 'subscribe']);
    Route::patch('/subscription', [PlanController::class, 'cancel']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'save']);
    Route::put('/profile', [ProfileController::class, 'save']);

    Route::get('/skills', [SkillController::class, 'index']);
    Route::get('/skills/{id}', [SkillController::class, 'show'])->whereNumber('id');
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills', [SkillController::class, 'updateFromQuery']);
    Route::delete('/skills', [SkillController::class, 'destroyFromQuery']);
    Route::put('/skills/{id}', [SkillController::class, 'update'])->whereNumber('id');
    Route::delete('/skills/{id}', [SkillController::class, 'destroy'])->whereNumber('id');

    Route::get('/needs', [NeedController::class, 'index']);
    Route::get('/needs/{id}', [NeedController::class, 'show'])->whereNumber('id');
    Route::post('/needs', [NeedController::class, 'store']);
    Route::put('/needs', [NeedController::class, 'updateFromQuery']);
    Route::delete('/needs', [NeedController::class, 'destroyFromQuery']);
    Route::put('/needs/{id}', [NeedController::class, 'update'])->whereNumber('id');
    Route::delete('/needs/{id}', [NeedController::class, 'destroy'])->whereNumber('id');

    Route::get('/offers', [OfferController::class, 'index']);
    Route::get('/offers/{id}', [OfferController::class, 'show'])->whereNumber('id');
    Route::post('/offers', [OfferController::class, 'store']);
    Route::put('/offers', [OfferController::class, 'updateFromQuery']);
    Route::delete('/offers', [OfferController::class, 'destroyFromQuery']);
    Route::put('/offers/{id}', [OfferController::class, 'update'])->whereNumber('id');
    Route::delete('/offers/{id}', [OfferController::class, 'destroy'])->whereNumber('id');

    Route::get('/matches', [MatchController::class, 'index']);

    foreach (['exchange-requests', 'exchange_requests'] as $uri) {
        Route::get("/{$uri}", [ExchangeRequestController::class, 'index']);
        Route::get("/{$uri}/{id}", [ExchangeRequestController::class, 'show'])->whereNumber('id');
        Route::post("/{$uri}", [ExchangeRequestController::class, 'store']);
        Route::patch("/{$uri}", [ExchangeRequestController::class, 'patchFromQuery']);
        Route::patch("/{$uri}/{id}", [ExchangeRequestController::class, 'patch'])->whereNumber('id');
    }

    foreach (['exchange-progress', 'exchange_progress'] as $uri) {
        Route::get("/{$uri}", [ExchangeProgressController::class, 'index']);
        Route::post("/{$uri}", [ExchangeProgressController::class, 'store']);
        Route::put("/{$uri}", [ExchangeProgressController::class, 'updateFromQuery']);
        Route::delete("/{$uri}", [ExchangeProgressController::class, 'destroyFromQuery']);
        Route::put("/{$uri}/{id}", [ExchangeProgressController::class, 'update'])->whereNumber('id');
        Route::delete("/{$uri}/{id}", [ExchangeProgressController::class, 'destroy'])->whereNumber('id');
    }

    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::post('/reviews', [ReviewController::class, 'store']);

    Route::get('/reputation', [ReputationController::class, 'show']);
});
