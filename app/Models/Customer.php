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

    public static function getCustomerById($id)
    {
        return self::where('id', $id)
                   ->get()->toArray();
    }
}
