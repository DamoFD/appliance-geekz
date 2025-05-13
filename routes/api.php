<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Middleware\CheckTokenLimit;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('web', 'auth')->group(function () {
    Route::get('/api/faults', [AiController::class, 'getFaults'])->middleware(CheckTokenLimit::class);
    Route::get('/api/test-mode', [AiController::class, 'getTestMode'])->middleware(CheckTokenLimit::class);
    Route::post('/api/chat', [AiController::class, 'chat'])->middleware(CheckTokenLimit::class);
    Route::post('/api/feedback', [FeedbackController::class, 'store']);
});
