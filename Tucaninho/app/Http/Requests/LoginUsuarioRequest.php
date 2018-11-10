<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUsuarioRequest extends FormRequest
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
            'email' => 'bail|email|required|max:100',
            'pwd' => 'bail|required|max:50'
        ];
    }

    public function messages(){
        return [
            'email.required' => 'O campo email é obrigatório',
            'email.max' => 'O campo email deve conter no máximo 100 caracteres',
            'email.email' => 'O campo deve ser um email válido',
            'pwd.required' => 'O campo senha é obrigatório',
            'pwd.max' => 'O campo senha deve conter no máximo 50 caracteres'
        ];
    }
}
