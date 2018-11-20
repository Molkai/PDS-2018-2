<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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
            'preco' => 'bail|required|numeric|between:0,999999.99',
            'descricao' => 'bail|required|min:20|max:3000',
            'preferencia' => 'nullable|max:1000'
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres',
            'between' => 'O campo :attribute deve ser no minimo :min e no máximo :max',
            'numeric' => 'O campo :attribute deve ser um número'
        ];
    }
}
