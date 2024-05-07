<?php
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// AUTH CONTROLLERS

Route::post('/auth/register', [AuthController::class, 'register']); // 
Route::post('/auth/login', [AuthController::class, 'login']); //
Route::post('/logout', [AuthController::class, 'userDisconnect'])->middleware('auth:sanctum');; //
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); //

