<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/push-notification', [\App\Http\Controllers\WebNotificationController::class, 'index'])->name('push-notification');
Route::post('/store-token', [\App\Http\Controllers\WebNotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [\App\Http\Controllers\WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');

require __DIR__.'/auth.php';
