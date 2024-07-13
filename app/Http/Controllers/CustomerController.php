<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCadastroRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Illuminate\Http\Request;

use App\Models\Customer;
use Ramsey\Uuid\Type\Integer;

class CustomerController extends Controller
{
    public function cadastro(CustomerCadastroRequest $request) {

        $request_data = $request->all();
        $cpf = $request_data['cpf'];
        $name = $request_data['nome']." ".$request_data['sobrenome'];
        $birth_date = $request_data['data_nascimento'];
        $email = $request_data['email'];
        $gender = $request_data['genero'];

        $customer = Customer::getCustomerByCpfAndEmail($cpf, $email);
        $mensagem = "";


        if (!empty(current($customer))) {

            if (current($customer)["email"] == $email) {
                $mensagem = "Email já cadastrado!";
            }
            if (current($customer)["cpf"] == $cpf) {
                $mensagem = "Cpf já cadastrado!";
            }

            return response()->json([
                'status' => false,
                'message' => $mensagem,
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
            'nome' => $name,
            'data_nascimento' => $birth_date,
            'email' => $email,
            'genero' => $gender
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

    public function getCustumerById(string $id) {

        $customer = Customer::getCustomerById($id);
        $customer = current($customer);
        if (empty($customer)) {
            return response()->json([
                'status' => false,
                'message' => 'Id não encontrado!',
                'data' => array(),
                '_links' => [
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                ]
            ], 400);
        }

        $response_data = array(
            "id" => $customer['id'],
			"nome" => $customer['name'],
			"cpf" => $customer['cpf'],
			"data_nascimento" => $customer['birth_date'],
			"email" => $customer['email'],
			"genero" => $customer['gender']
        );

        return response()->json([
            'status' => true,
            'data' => $response_data,
            '_links' => array(
                '_self' => "",
                '_update' => "",
                '_create' => "",
                '_delete' => "",
                '_getAll' => ""
            )
        ], 200);
    }

    public function deleteCustumerById(string $id) {

        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Id não encontrado!',
                'data' => array(),
                '_links' => [
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                ]
            ], 400);
        } 

        $destroy = Customer::destroy($id);
        if (!$destroy) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao tentar excluir Id!',
                'data' => array(),
                '_links' => [
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                ]
            ], 500);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Id excluido com sucesso!',
            'id' => $id,
            '_links' => array(
                '_create' => "",
                '_getAll' => ""
            )
        ], 200);

    }

    public function updateCustomerById(CustomerUpdateRequest $request, string $id)
    {

        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Id não encontrado!',
                'data' => array(),
                '_links' => [
                    '_self' => "",
                    '_update' => "",
                    '_create' => "",
                    '_delete' => "",
                    '_getAll' => ""
                ]
            ], 400);
        } 

        $request_data = $request->all();
        $cpf = $request_data['cpf'];
        $name = $request_data['nome']." ".$request_data['sobrenome'];
        $birth_date = $request_data['data_nascimento'];
        $email = $request_data['email'];
        $gender = $request_data['genero'];


        $customer->name = $name;
        $customer->cpf = $cpf;
        $customer->birth_date = $birth_date;
        $customer->email = $email;
        $customer->gender = $gender;
        $customer->updated_at = now();  
        $customer->save();  

        $data = array(
            'id' => $id,
            'cpf' => $cpf,
            'nome' => $name,
            'data_nascimento' => $birth_date,
            'email' => $email,
            'genero' => $gender
        );

        return response()->json([
            'status' => true,
            'message' => 'Cliente atualizado com sucesso!',
            'data' => $data,
            '_links' => array(
                '_self' => "",
                '_update' => "",
                '_create' => "",
                '_delete' => "",
                '_getAll' => ""
            )
        ], 200);
    }

    public function getCustumers(Request $request)
    {

        $messages = [
            'pageSize.integer' => 'Tamanho da pagina deve ser um inteiro.',
            'pageSize.max' => 'Tamanho máximo de pagina é 100.',
        ];

        $validated = $request->validate([
            'pageSize' => 'integer|max:100'
        ]);
        
        $pageSize = $request->query('pageSize', 15); 

        $customers = Customer::getCustomers($pageSize);

        return response()->json($customers);

    }
}
