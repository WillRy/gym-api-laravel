<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PlanoRequest extends FormRequest
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
        $id = Route::current()->parameter("idPlano") ?? Route::current()->parameter("plano");
        return [
            "nome" => "required|max:255|min:3|unique:planos,nome," . $id . ",id",
            "descricao" => "nullable|max:255|min:3",
            "duracao" => "required|integer|min:1",
            "valor" => "required|numeric"
        ];
    }
}
