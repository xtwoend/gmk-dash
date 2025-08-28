<?php

use App\Http\Controllers\Api\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Middleware\DeviceMiddleware;

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.auth.login');

Route::middleware(['auth:sanctum', DeviceMiddleware::class])->group(function () {
    // Authentication routes
    Route::get('validate', [AuthController::class, 'me'])->name('api.auth.me');
    Route::post('verify', [AuthController::class, 'verify'])->name('api.auth.verify');
    Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');
    Route::get('users/{id}', [AuthController::class, 'user'])->name('api.auth.user');

    // devices active
    Route::get('devices', [DeviceController::class, 'index'])->name('api.devices.index');
    Route::get('devices/{id}', [DeviceController::class, 'show'])->name('api.devices.show');

    // Shift
    Route::get('shift', [ShiftController::class, 'active'])->name('api.shift.active');


    // Activity
    Route::get('activity', [ActivityController::class, 'active'])->name('api.activity.active');
    Route::post('activity/startup', [ActivityController::class, 'startup'])->name('api.activity.startup');
    Route::post('activity/pause', [ActivityController::class, 'pause'])->name('api.activity.pause');
    Route::post('activity/finish', [ActivityController::class, 'finish'])->name('api.activity.finish');

    Route::post('activity/verification', [ActivityController::class, 'verification'])->name('api.activity.verification');
    Route::put('activity/verification', [ActivityController::class, 'verificationUpdate'])->name('api.activity.verification.update');
    Route::post('activity/verification-activity', [ActivityController::class, 'verificationActivity'])->name('api.activity.verification-activity');
    Route::put('activity/verification-activity', [ActivityController::class, 'verificationActivityUpdate'])->name('api.activity.verification-activity.update');

    Route::post('activity/detected', [ActivityController::class, 'detected'])->name('api.activity.detected');
    Route::post('activity/ng-confirm', [ActivityController::class, 'ngConfirm'])->name('api.activity.ng-confirm');
    Route::post('activity/ng-action', [ActivityController::class, 'ngAction'])->name('api.activity.ng-action');
    Route::post('activity/product', [ActivityController::class, 'scanProduct'])->name('api.activity.product');

    Route::put('activity/record/{id}', [ActivityController::class, 'updateActivity'])->name('api.activity.record.update');
    Route::get('activity/record/{id}', [ActivityController::class, 'getActivity'])->name('api.activity.record');
});