<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

Route::get('/buku', [BukuController::class, 'index']);
Route::post('/buku', [BukuController::class, 'store']);
Route::put('/buku/{id}', [BukuController::class, 'update']);
Route::delete('/buku/{id}', [BukuController::class, 'destroy']);
