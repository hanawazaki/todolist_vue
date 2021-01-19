<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodolistController;
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
Route::get('list', [TodolistController::class, 'getList']);
Route::post('list/create', [TodolistController::class, 'postList']);
Route::get('list/edit/{id}', [TodolistController::class, 'editData']);
Route::post('list/update/{id}', [TodolistController::class, 'postUpdate']);
Route::post('list/delete/{id}', [TodolistController::class, 'delete']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


