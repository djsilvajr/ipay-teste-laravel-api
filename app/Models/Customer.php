<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        $query = Customer::query();
        return $query->orderBy('name') 
                           ->paginate($pageSize); 

    }
}
