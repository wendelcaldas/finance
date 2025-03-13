<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Rotas protegidas pelo sanctum apenas são validadas pelo bearer, caso precisemos de rotas pra login e senha usar auth:basic
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/financeiro', [FinanceiroController::class, 'index']);