<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfValidation;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => ['required', 'numeric', new CpfValidation()],
            'nome' => ['required', 'string', 'max:16'],
            'sobrenome' => ['required', 'string', 'max:16'],
            'data_nascimento' => ['required', 'date_format:Y-m-d', 'before:today'],
            'email' => ['required', 'email'],
            'genero' => ['required', 'in:F,M'],
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.numeric' => 'Formato inválido. O formato correto é 99999999999',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser do tipo string.',
            'nome.max' => 'Capacidade maxima para campo nome é de 16 caracteres.',
            'sobrenome.required' => 'O campo sobrenome é obrigatório.',
            'sobrenome.string' => 'O campo sobrenome deve ser do tipo string.',
            'sobrenome.max' => 'Capacidade maxima para campo sobrenome é de 16 caracteres.',
            'data_nascimento.required' => 'O campo data_nascimento é obrigatório.',
            'data_nascimento.date_format' => 'Formato inválido. O formato correto é Y-m-d.',
            'data_nascimento.before' => 'A data de nascimento a ser preenchida deve ser menor que hoje.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Formato do email inválido.',
            'genero.required' => 'O campo genero é obrigatório.',
            'genero.in' => 'Só aceitamos no campo genero F para feminino e M para masculino.'
        ];
    }
}
