<?php
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// CHAT CONTROLLERS
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/chats', [ChatController::class, 'getUserChats']); //
    Route::post('/chats', [ChatController::class, 'createNewChat']); //
    Route::put('/chats/{id}', [ChatController::class, 'updateChat']); //
    Route::delete('/chats/{id}', [ChatController::class, 'deleteChat']); //
    });