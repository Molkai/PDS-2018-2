<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClienteRequest extends FormRequest
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
            'email' => 'bail|required|email|unique:cliente,email_cliente|max:100',
            'nome' => 'bail|required|min:5|max:100',
            'pwd' => 'bail|required|min:4|max:50',
            'pwd2' => 'bail|required|min:4|max:50',
        ];
    }

    public function messages(){
        return [
            'email.required' => 'O campo email é obrigatório',
            'nome.required' => 'O campo nome é obrigatório',
            'pwd.required' => 'O campo senha é obrigatório',
            'pwd2.required' => 'A confirmação da senha é obrigatória',
            'email.email' => 'O campo deve ser um email válido',
            'email.max' => 'O campo email deve conter no máximo 100 caracteres',
            'email.unique' => 'Email já cadastrado no sistema',
            'nome.max' => 'O campo nome deve conter no máximo 100 caracteres',
            'nome.min' => 'O campo nome deve conter no mínimo 5 caracteres',
            'pwd.max' => 'O campo senha deve conter no máximo 50 caracteres',
            'pwd.min' => 'O campo senha deve conter no mínimo 4 caracteres',
            'pwd2.max' => 'O campo de confirmação de senha deve conter no máximo 50 caracteres',
            'pwd2.min' => 'O campo de confirmação de senha deve conter no mínimo 4 caracteres'
        ];
    }
}
