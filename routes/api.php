<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangKeluarController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);
Route::apiResource('obat', ObatController::class);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);