<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistributorController;


Route::apiResource('distributor', DistributorController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);
Route::get('/laporan/harian', [LaporanController::class, 'harian']);
Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan']);
Route::get('/laporan/harian/pdf', [LaporanController::class, 'harianPdf']);
Route::get('/laporan/bulanan/pdf', [LaporanController::class, 'bulananPdf']);

Route::get('/notifications', [NotificationController::class, 'notifications']);
Route::post('/notifications/mark-read', [NotificationController::class, 'markRead']);

Route::apiResource('obat', ObatController::class);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);