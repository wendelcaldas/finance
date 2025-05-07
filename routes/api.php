<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\TotvsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user/{userId}/movimentacoes', [UserController::class, 'getMovimentacoesByUser']);

Route::post('/movimentacao', [MovimentacaoController::class, 'store']);

// Rotas protegidas pelo sanctum apenas são validadas pelo bearer, caso precisemos de rotas pra login e senha usar auth:basic
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::middleware('role:user')->group(function () {
    //     Route::get('/admin', [FinanceiroController::class, 'testeRole']);
    // });

    Route::get('/admin', [FinanceiroController::class, 'testeRole']);
    // ->middleware('role');

    // Rotas que comunicam com a totvs - Prefixo /totvs/nomedarota
    Route::prefix('totvs')->group(function () {
        Route::get('/buscar', [TotvsController::class, 'buscarDados']);
    });

});

Route::get('/financeiro', [FinanceiroController::class, 'index']);

