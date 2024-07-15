<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';

    protected $fillable = [
        'cpf',
        'name',
        'birth_date',
        'email',
        'gender',
        'updated_at'
    ];

    public static function getCustomerByCpf($cpf)
    {
        return self::where('cpf', $cpf)
                   ->get()->toArray();
    }

    public static function getCustomerByCpfAndEmail($cpf, $email)
    {
        return self::where('cpf', $cpf)
                   ->orWhere('email', $email)
                   ->get()->toArray();
    }

    public static function getCustomerById($id)
    {
        return self::where('id', $id)
                   ->get()->toArray();
    }

    public static function getCustomers($pageSize)
    {
        $customers = DB::table('customer')
        ->select('id', 'name', 'cpf', 'birth_date', 'email', 'gender', 'created_at', 'updated_at')
        ->get();

        $processedCustomers = $customers->map(function($customer) {
            $nameParts = explode(' ', $customer->name);

            // Verifica se há pelo menos duas partes (nome e sobrenome)
            if (count($nameParts) >= 2) {
                $customer->name = $nameParts[0];
                $customer->surname = implode(' ', array_slice($nameParts, 1));
            } else {
                $customer->name = $customer->name;
                $customer->surname = '';
            }

            return $customer;
        });

    return response()->json($processedCustomers);

    }
}
