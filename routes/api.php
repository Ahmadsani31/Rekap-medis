<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DocterController;
use App\Http\Controllers\API\ObatController;
use App\Http\Controllers\API\PasienController;
use App\Http\Controllers\API\RekapMedisController;
use App\Http\Controllers\API\RuanganController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => [JwtMiddleware::class],
    'prefix' => 'v1'
], function ($router) {
    Route::get('dashboard', [DashboardController::class, 'get']);

    Route::post('docter/store', [DocterController::class, 'store']);
    Route::get('docter', [DocterController::class, 'get']);
    Route::get('docter/edit/{id}', [DocterController::class, 'edit']);
    Route::post('docter/update', [DocterController::class, 'update']);
    Route::delete('docter/delete/{id}', [DocterController::class, 'destroy']);

    Route::get('pasien', [PasienController::class, 'get']);
    Route::post('pasien/store', [PasienController::class, 'store']);
    Route::get('pasien/edit/{id}', [PasienController::class, 'edit']);
    Route::put('pasien/update/{id}', [PasienController::class, 'update']);
    Route::delete('pasien/delete/{id}', [PasienController::class, 'destroy']);

    Route::get('obat', [ObatController::class, 'get']);
    Route::post('obat/store', [ObatController::class, 'store']);
    Route::get('obat/edit/{id}', [ObatController::class, 'edit']);
    Route::put('obat/update/{id}', [ObatController::class, 'update']);
    Route::delete('obat/delete/{id}', [ObatController::class, 'destroy']);

    Route::get('ruangan', [RuanganController::class, 'get']);
    Route::post('ruangan/store', [RuanganController::class, 'store']);
    Route::get('ruangan/edit/{id}', [RuanganController::class, 'edit']);
    Route::put('ruangan/update/{id}', [RuanganController::class, 'update']);
    Route::delete('ruangan/delete/{id}', [RuanganController::class, 'destroy']);

    Route::post('medis/store', [RekapMedisController::class, 'store']);
    Route::get('medis/data-medis', [RekapMedisController::class, 'dataMedis']);
    Route::get('medis/laporan', [RekapMedisController::class, 'laporan']);
    Route::delete('laporan/delete/{id}', [RekapMedisController::class, 'destroy']);

    Route::get('user-all', [UserController::class, 'get']);

    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'v1'
// ], function ($router) {
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
//     Route::get('user', [AuthController::class, 'getUser'])->middleware('auth:api');
//     // Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
//     // Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
// });
