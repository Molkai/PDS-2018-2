<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfertaRequest extends FormRequest
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
        ];
    }

    public function messages(){
        return [
            'preco.required' => 'O campo preço é obrigatório',
            'between' => 'O campo :attribute deve ser no minimo :min e no máximo :max',
            'numeric' => 'O campo :attribute deve ser um número',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.min' => 'O campo descrição deve ter no mínimo :min caracteres',
            'descricao.max' => 'O campo descrição deve ter no máximo :max caracteres'
        ];
    }
}
