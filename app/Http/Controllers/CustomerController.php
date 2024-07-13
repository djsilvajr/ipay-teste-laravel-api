<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCadastroRequest;
use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function cadastro(CustomerCadastroRequest $request) {

        $request_data = $request->all();
        $cpf = $request_data['cpf'];
        $name = $request_data['nome']." ".$request_data['sobrenome'];
        $birth_date = $request_data['data_nascimento'];
        $email = $request_data['email'];
        $gender = $request_data['genero'];

        $customer = Customer::getCustomerByCpf($cpf);
        if (!empty(current($customer))) {
            return response()->json([
                'status' => true,
                'message' => 'Cpf já cadastrado!',
                'data' => current($customer),
                '_links' => [
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                ]
            ], 409);
        }

        $customer = Customer::create([
            'cpf' => $cpf,
            'name' => $name,
            'birth_date' => $birth_date,
            'email' => $email,
            'gender' => $gender,
        ])->id;

        if(!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar cliente.',
                'data' => array(),
                '_links' => array(
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                )
            ], 500);
        }

        $data = array(
            'id' => $customer,
            'cpf' => $cpf,
            'name' => $name,
            'birth_date' => $birth_date,
            'email' => $email,
            'gender' => $gender
        );

        return response()->json([
            'status' => true,
            'message' => 'Cliente registrado com sucesso!',
            'data' => $data,
            '_links' => array(
                '_self' => "",
                '_update' => "",
                '_create' => "",
                '_delete' => "",
                '_getAll' => ""
            )
        ], 201);
    }
}
