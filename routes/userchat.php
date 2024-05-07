<?php
use App\Http\Controllers\UserChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// USERCHAT CONTROLLERS

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/userchats/{id}', [UserChatController::class, 'getUsersChat']);//
    Route::post('/userchats/user/{userId}/chat/{chatId}', [UserChatController::class, 'addUserToChat']);//
    Route::delete('/userchats/user/{userId}/chat/{chatId}', [UserChatController::class, 'removeUserToChat']);//
    Route::delete('/userchats/user/{chatId}', [UserChatController::class, 'leaveChat']);//
    });