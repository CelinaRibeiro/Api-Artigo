<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtigoController;


Route::get('ping', function() {
    return ['pong' => true];
});

Route::post('/auth/user', [AuthController::class, 'create']);
Route::post('/auth/login', [AuthController::class, 'login']);


Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/auth/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/auth/me', [AuthController::class, 'me']); //pegar o user logado

Route::middleware('auth:api')->post('/artigo', [ArtigoController::class, 'create']);
Route::middleware('auth:api')->get('/artigos', [ArtigoController::class, 'readAll']);
Route::middleware('auth:api')->get('/artigo/{id}', [ArtigoController::class, 'read']);
Route::middleware('auth:api')->put('/artigo/{id}', [ArtigoController::class, 'update']);
Route::middleware('auth:api')->delete('/artigo/{id}', [ArtigoController::class, 'delete']);


