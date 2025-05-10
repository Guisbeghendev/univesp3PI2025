<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EspecializacaoController;

Route::get('/especializacoes', [EspecializacaoController::class, 'index']);
Route::get('/especializacoes/{id}', [EspecializacaoController::class, 'show']);
Route::post('/especializacoes', [EspecializacaoController::class, 'store']);
Route::put('/especializacoes/{id}', [EspecializacaoController::class, 'update']);
Route::delete('/especializacoes/{id}', [EspecializacaoController::class, 'destroy']);
