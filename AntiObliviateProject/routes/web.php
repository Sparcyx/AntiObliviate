<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimeRecordController;

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
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search-animes', [DashboardController::class, 'searchAnimes'])->name('searchAnimes');
    
    Route::get('/personal', [AnimeController::class, 'myAnimeList'])->name('personal');
    
    Route::get('/anime/{id}', [AnimeRecordController::class, 'show'])->name('anime.show');
    Route::put('/anime/{id}', [AnimeRecordController::class, 'update'])->name('anime.update');
    Route::delete('/anime/{id}', [AnimeRecordController::class, 'destroy'])->name('anime.destroy');
    
    Route::post('/anime/{id}/add', [AnimeController::class, 'addToList'])->name('anime.add');

    Route::get('/filterAnimes', [App\Http\Controllers\AnimeController::class, 'filterAnimes'])->name('filterAnimes');
});

require __DIR__.'/auth.php';
