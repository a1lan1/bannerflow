<?php

declare(strict_types=1);

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\V1\Banner\BannerController;
use App\Http\Controllers\Api\V1\Banner\BannerScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', fn (Request $request) => $request->user());

    // Notifications
    Route::prefix('notifications')->name('api.notifications.')->group(function (): void {
        Route::get('', [NotificationController::class, 'index'])->name('index');
        Route::post('read', [NotificationController::class, 'markAllAsRead'])->name('read_all');
        Route::post('{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::delete('{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // v1
    Route::prefix('v1')->name('api.v1.')->group(function (): void {
        // Banners
        Route::prefix('banners')->name('banners.')->group(function (): void {
            Route::get('', [BannerController::class, 'index'])->name('index');
            Route::get('{placement}', [BannerController::class, 'show'])->name('show');

            Route::prefix('schedule')->name('schedule.')->group(function (): void {
                Route::get('{banner}', [BannerScheduleController::class, 'index'])->name('index');
                Route::put('{banner}', [BannerScheduleController::class, 'update'])->name('update');
            });
        });
    });
});
