<?php
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// USER CONTROLLERS 

Route::middleware(['auth:sanctum'])->group(function () {

    // Your profile
    Route::get('/user/me', [UserController::class, 'getProfile']); // 
    Route::put('/user/me', [UserController::class, 'updateProfile']); //
    
    // Other profiles
    Route::get('/users', [UserController::class, 'getAllUsers']);//
    Route::get('/users/{id}', [UserController::class, 'getUserProfile']); //
    Route::put('/users/{id}', [UserController::class, 'updateUserProfile'])->middleware('admin'); //
    Route::delete('/users', [UserController::class, 'deleteUserAccount'])->middleware('admin');//
    });