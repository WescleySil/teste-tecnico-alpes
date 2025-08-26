<?php

use App\Http\Controllers\AnnouncementPhotoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleAnnouncementController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/user', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('vehicles')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::post('/', [VehicleController::class, 'store']);
        Route::put('/{vehicle}', [VehicleController::class, 'update']);
        Route::delete('/{vehicle}', [VehicleController::class, 'destroy']);
    });

    Route::prefix('vehicle-announcements')->group(function () {
        Route::get('/', [VehicleAnnouncementController::class, 'index']);
        Route::post('/', [VehicleAnnouncementController::class, 'store']);
        Route::put('/{vehicle_announcement}', [VehicleAnnouncementController::class, 'update']);
        Route::delete('/{vehicle_announcement}', [VehicleAnnouncementController::class, 'destroy']);
    });

    Route::prefix('announcement-photos')->group(function () {
        Route::get('/', [AnnouncementPhotoController::class, 'index']);
        Route::post('/', [AnnouncementPhotoController::class, 'store']);
        Route::put('/{announcement_photo}', [AnnouncementPhotoController::class, 'update']);
        Route::delete('/{announcement_photo}', [AnnouncementPhotoController::class, 'destroy']);
    });
});
