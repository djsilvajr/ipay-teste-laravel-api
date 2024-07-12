<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id()->comment('Chave primeira da tabela de clientes.'); 
            $table->string('name')->comment('Nome do cliente.');
            $table->date('birth_date')->comment('data de nascimento do cliente.');
            $table->string('email')->unique()->comment('Email do cliente.');
            $table->enum('gender', ['M', 'F'])->comment('Genero do cliente M para masculino e F para feminino.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
