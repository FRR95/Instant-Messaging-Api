<?php
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// MESSAGE CONTROLLERS

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/messages/{chatId}', [MessageController::class, 'getMessagesFromChat']);  // 
    Route::post('/messages/{chatId}', [MessageController::class, 'createMessage']);   //
    Route::put('/messages/{chatId}/message/{messageId}', [MessageController::class, 'updateMessage']);   //
    Route::delete('/messages/{chatId}/message/{messageId}', [MessageController::class, 'deleteMessage']);  // 
    });