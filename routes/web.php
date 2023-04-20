<?php

use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Schedule\ScheduleCreateController;
use App\Http\Controllers\Schedule\ScheduleDeleteController;
use App\Http\Controllers\Schedule\ScheduleEditController;
use App\Http\Controllers\Schedule\ScheduleStoreController;
use App\Http\Controllers\Schedule\ScheduleUpdateController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\Tweet\TweetDeleteController;
use App\Http\Controllers\Tweet\TweetEditController;
use App\Http\Controllers\Tweet\TweetStoreController;
use App\Http\Controllers\Tweet\TweetUpdateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::post('tweets', TweetStoreController::class)->name('tweets.store');
Route::get('tweets/{id}/edit', TweetEditController::class)->name('tweet.edit');
Route::put('tweets/{id}', TweetUpdateController::class)->name('tweet.update');
Route::delete('tweets/{id}', TweetDeleteController::class)->name('tweet.destroy');

Route::get('/timeline', TimelineController::class)->middleware(['auth', 'verified'])->name('timeline');
Route::get('/jadwal', JadwalController::class)->middleware(['auth', 'verified'])->name('jadwal');

Route::middleware('auth')->group(function () {
    Route::get('schedule', ScheduleCreateController::class)->middleware('can:buat_jadwal')->name('schedule.create');
    Route::post('schedule', ScheduleStoreController::class)->middleware('can:buat_jadwal')->name('schedule.store');
    Route::get('schedule/{id}/edit', ScheduleEditController::class)->middleware('can:buat_jadwal')->name('schedule.edit');
    Route::put('schedule/{id}', ScheduleUpdateController::class)->middleware('can:buat_jadwal')->name('schedule.update');
    Route::delete('schedule/{id}', ScheduleDeleteController::class)->middleware('can:buat_jadwal')->name('schedule.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
