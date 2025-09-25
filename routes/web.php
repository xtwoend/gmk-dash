<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceProductController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    
    // Devices Management
    Route::resource('devices', DeviceController::class)->middleware('permission:device-list|device-create|device-edit|device-delete');
    Route::patch('/devices/{device}/toggle-status', [DeviceController::class, 'toggleStatus'])
        ->name('devices.toggle-status')
        ->middleware('permission:device-edit');
    
    // Device Products Management
    Route::resource('device-products', DeviceProductController::class)->middleware('permission:device-list|device-create|device-edit|device-delete');
    
    // Shifts Management
    Route::resource('shifts', ShiftController::class)->middleware('permission:shift-list|shift-create|shift-edit|shift-delete');
    
    // Startup Management and Reports
    Route::get('/startups', [App\Http\Controllers\StartupController::class, 'index'])->name('startups.index')->middleware('permission:startup-list');
    Route::get('/startups/report', [App\Http\Controllers\StartupController::class, 'report'])->name('startups.report')->middleware('permission:startup-list');
    Route::get('/startups/analytics', [App\Http\Controllers\StartupController::class, 'analytics'])->name('startups.analytics')->middleware('permission:startup-list');
    Route::get('/startups/{startup}', [App\Http\Controllers\StartupController::class, 'show'])->name('startups.show')->middleware('permission:startup-list');
    Route::post('/startups/ng-confirm', [App\Http\Controllers\StartupController::class, 'ngConfirm'])->name('startups.ng-confirm')->middleware('permission:startup-edit');
    Route::post('/startups/verification-confirm', [App\Http\Controllers\StartupController::class, 'verificationConfirm'])->name('startups.verification-confirm')->middleware('permission:startup-edit');
    Route::post('/startups/activity-confirm', [App\Http\Controllers\StartupController::class, 'activityConfirm'])->name('startups.activity-confirm')->middleware('permission:startup-edit');

    // User Management
    Route::resource('users', UserController::class)->middleware('permission:user-list|user-create|user-edit|user-delete');
    
    // Role Management
    Route::resource('roles', RoleController::class)->middleware('permission:role-list|role-create|role-edit|role-delete');
    
    // Permission Management
    Route::resource('permissions', PermissionController::class)->middleware('permission:permission-list|permission-create|permission-edit|permission-delete');
    
    Route::get('/products', function() {
        return view('dashboard.index')->with('message', 'Products page - coming soon!');
    })->name('products.index')->middleware('permission:product-list');
    
    Route::get('/records', function() {
        return view('dashboard.index')->with('message', 'Records page - coming soon!');
    })->name('records.index')->middleware('permission:record-list');
    
    Route::get('/activities', function() {
        return view('dashboard.index')->with('message', 'Activities page - coming soon!');
    })->name('activities.index')->middleware('permission:activity-list');
    
    Route::get('/verifications', function() {
        return view('dashboard.index')->with('message', 'Verifications page - coming soon!');
    })->name('verifications.index')->middleware('permission:verification-list');
});

// Temporary routes for development
Route::get('/register', function() {
    return redirect()->route('login')->with('info', 'Registration is currently disabled.');
})->name('register');

Route::get('/password/request', function() {
    return redirect()->route('login')->with('info', 'Password reset is currently disabled.');
})->name('password.request');

Route::get('health', function () {
    return response()->json(['status' => 'ok']);
});
