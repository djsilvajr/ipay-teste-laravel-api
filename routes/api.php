<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

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

//clientes
//função para cadartrar clientes
Route::post('/Customer/Cadastro', [CustomerController::class, 'cadastro']);
Route::get('/Customer/{id}', [CustomerController::class, 'getCustumerById']);
Route::delete('/Customer/{id}', [CustomerController::class, 'deleteCustumerById']);
