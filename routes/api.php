<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GoogleController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ZoomController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/task', [TaskController::class, 'createTask']);
    Route::put('/task/{id}', [TaskController::class, 'updateTask']);
    Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);
    Route::get('/task', [TaskController::class, 'getAllTask']);
    Route::get('/user', [UserController::class, "getAllUser"]);
    Route::post('/todotask', [TaskController::class, 'createTodoTask']);
    Route::patch('/todotask/completed/{id}', [TaskController::class, 'setCompleteTodoTask']);
    Route::delete('/todotask/{id}', [TaskController::class, 'deleteTodoTask']);


    Route::post('/logout', [AuthController::class, 'logout']);
});
