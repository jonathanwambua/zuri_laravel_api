<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function(){
    //--create user
    Route::post('/user/create', [UserController::class, 'create']);
    //--login user
    Route::post('/user/login', [UserController::class, 'login']);

    //--delete user
    Route::get('/user/delete/{id}', [UserController::class, 'deleteUser']);
    //--update user
    Route::put('/user/update/{id}', [UserController::class, 'updateUser']);
    //--all users
    Route::get('/users', [UserController::class, 'getUsers']);
    //--Users by Id
    Route::get('/user/{id}', [UserController::class, 'getUserById']);
});
