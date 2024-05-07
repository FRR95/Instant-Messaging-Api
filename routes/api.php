<?php

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


require __DIR__ . './auth.php' ;
require __DIR__ . './chat.php' ;
require __DIR__ . './message.php' ;
require __DIR__ . './user.php' ;
require __DIR__ . './userchat.php' ;

