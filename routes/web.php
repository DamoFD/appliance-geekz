<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WaitlistController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\FeedbackController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/dashboard', function () {
    return view('new-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', CheckAdmin::class])->name('admin.index');
Route::get('/admin/new-user', [AdminController::class, 'create'])->middleware(['auth', CheckAdmin::class])->name('admin.new-user');
Route::post('/admin/new-user', [AdminController::class, 'store'])->middleware(['auth', CheckAdmin::class])->name('admin.store-user');
Route::get('/admin/new-user/{user}', [AdminController::class, 'edit'])->middleware(['auth', CheckAdmin::class])->name('admin.edit-user');
Route::put('/admin/new-user/{user}', [AdminController::class, 'update'])->middleware(['auth', CheckAdmin::class])->name('admin.update-user');
Route::delete('/admin/new-user/{user}', [AdminController::class, 'destroy'])->middleware(['auth', CheckAdmin::class])->name('admin.destroy-user');
Route::get('/admin/waitlist', [AdminController::class, 'waitlist'])->middleware(['auth', CheckAdmin::class])->name('admin.waitlist');
Route::get('/admin/feedback', [FeedbackController::class, 'index'])->middleware(['auth', CheckAdmin::class])->name('admin.feedback');
Route::get('/admin/feedback/{feedback}', [FeedbackController::class, 'show'])->middleware(['auth', CheckAdmin::class])->name('admin.show-feedback');

Route::get('/app', function () {
    return view('app');
})->middleware(['auth', 'verified'])->name('app');

Route::get('/app/{any}', function () {
    return view('app');
})->middleware(['auth', 'verified']);

Route::post('/waitlist', [WaitlistController::class, 'store'])->middleware('throttle:5')->name('waitlist.submit');

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
