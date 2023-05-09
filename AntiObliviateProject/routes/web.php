<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FicheAnimeController;

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
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/personal', [AnimeController::class, 'myAnimeList'])->middleware(['auth'])->name('personal');
Route::get('/search-animes', [DashboardController::class, 'searchAnimes'])->name('searchAnimes');
Route::get('/anime/{id}', [FicheAnimeController::class, 'show'])->middleware(['auth'])->name('anime.show');

Route::put('/fiche_anime/{id}', [FicheAnimeController::class, 'update'])->name('fiche_anime.update');

Route::post('/animes/{id}/ajouter', [AnimeController::class, 'ajouterALaListe'])->name('ajouter_anime_route');

Route::delete('/anime/{id}/supprimer', [AnimeController::class, 'supprimer_anime_route'])->name('supprimer_anime_route');
