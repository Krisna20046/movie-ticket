<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PemesananController;

Route::get('/', [FilmController::class, 'index'])->name('films.index');
Route::get('/film/{id}', [FilmController::class, 'show']);
Route::get('/jadwal/{id}/pilih-kursi', [PemesananController::class, 'pilihKursi']);
Route::post('/pesan', [PemesananController::class, 'store']);