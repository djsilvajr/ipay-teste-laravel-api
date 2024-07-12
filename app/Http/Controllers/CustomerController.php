<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCadastroRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function cadastro(CustomerCadastroRequest $request) {
        print_r($request->all());
        die;

        return response()->json(['message' => 'Cliente registrado com sucesso!']);
    }
}
