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
            'preco' => 'bail|required|min:1|max:9',
            'descricao' => 'bail|required|min:20|max:3000',
        ];
    }

    public function messages(){
        return [
            'preco.required' => 'O campo preço é obrigatório',
            'preco.min' => 'O campo preço deve ter no mínimo :min caracteres',
            'preco.max' => 'O campo preço deve ter no máximo :max caracteres',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.min' => 'O campo descrição deve ter no mínimo :min caracteres',
            'descricao.max' => 'O campo descrição deve ter no máximo :max caracteres'
        ];
    }
}
