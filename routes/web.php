<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\AiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('app');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/{any}', function () {
    return view('app');
})->middleware(['auth', 'verified']);

Route::post('/get-date', [DateController::class, 'getDate'])->name('getDate');
Route::post('/get-ge-date', [DateController::class, 'getGEDate'])->name('getGEDate'); //[getGEDate]
Route::post('/ask', [AiController::class, 'ask'])->name('ask');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
