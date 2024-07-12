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

//função criada no inicio do projeto
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//clientes
//função para cadartrar clientes
//Route::post('/Customer/Cadastro', [CustomerController::class, 'cadastro']);
Route::post('/Customer/Cadastro', [CustomerController::class, 'cadastro']);

Route::post('/test', function () {
    return 'POST method accepted';
});