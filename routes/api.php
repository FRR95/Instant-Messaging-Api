<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserChatController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return "GET ALL ROLES";
});


// AUTH CONTROLLERS

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);


// USER CONTROLLERS 

Route::middleware(['auth:sanctum'])->group(function () {

// Your profile
Route::get('/user/me', [UserController::class, 'getProfile']);
Route::put('/user/me', [UserController::class, 'updateProfile']);

// Other profiles
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/users/{id}', [UserController::class, 'getUserProfile']);
Route::put('/users/{id}', [UserController::class, 'updateUserProfile'])->middleware('admin');
Route::delete('/users/{id}', [UserController::class, 'deleteUserAccount'])->middleware('admin');
});


// CHAT CONTROLLERS
Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/chats', [ChatController::class, 'getUserChats']);
Route::post('/chats', [ChatController::class, 'createNewChat']);
Route::put('/chats/{id}', [ChatController::class, 'updateChat']);
Route::delete('/chats/{id}', [ChatController::class, 'deleteChat']);
});

// USERCHAT CONTROLLERS

Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/userchats/{id}', [UserChatController::class, 'getUsersChat']);
Route::post('/userchats/user/{userId}/chat/{chatId}', [UserChatController::class, 'addUserToChat']);
Route::delete('/userchats/user/{userId}/chat/{chatId}', [UserChatController::class, 'removeUserToChat']);
Route::delete('/userchats/user/{chatId}', [UserChatController::class, 'leaveChat']);
});

// MESSAGE CONTROLLERS

Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/messages/{chatId}', [MessageController::class, 'getMessagesFromChat']);   
Route::post('/messages/{chatId}', [MessageController::class, 'createMessage']);   
Route::put('/messages/{chatId}/message/{messageId}', [MessageController::class, 'updateMessage']);   
Route::delete('/messages/{chatId}/message/{messageId}', [MessageController::class, 'deleteMessage']);   
});

