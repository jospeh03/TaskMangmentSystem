<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Admin Routes
Route::middleware(['auth.jwt', 'role:admin'])->group(function () {
    Route::get('/tasks', [AdminController::class, 'indexTask']);
    Route::post('/tasks', [AdminController::class, 'createTask']);
    Route::put('/tasks/{id}', [AdminController::class, 'updateTask']);
    Route::delete('/tasks/{id}', [AdminController::class, 'deleteTask']);
    Route::get('/admin/users', [AdminController::class, 'index']);
    Route::post('/admin/users', [AdminController::class, 'store']);
    Route::get('/admin/users/{id}', [AdminController::class, 'show']);
    Route::put('/admin/users/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Manager Routes
Route::middleware(['auth.jwt', 'role:manager'])->group(function () {
    Route::post('/tasks/{id}/assign', [ManagerController::class, 'assignTask']);
});

// User Routes dont forget to don't miss up with auth sanctum
Route::prefix('user')->middleware(['auth.jwt', 'role:user'])->group(function () {
    Route::put('/tasks/{id}/status', [UserController::class, 'updateTaskStatus']);
});
