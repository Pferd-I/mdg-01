<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTipoBecaRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
        return true;
    }
    public function messages(){
        return[
            'required'=> 'Este campo es requerido.',
            'max' => 'Por favor, coloque menos caracteres.',
            'unique' => 'Esa beca ya existe.',
            'between' => 'El valor debe estar entre 0 y 100.',
            'numeric' => 'Por favor, coloque un número en Descuento.',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array{
        return [
            /*'nombre_tipo_beca' => ['required', 'string', 'max:20'],
            'descripcion' => ['string'],
            'dcto' => ['required', 'between:0,100', 'numeric'],
            'estado' => [],*/
            'nombre_tipo_beca' => ['required', 'max:25', Rule::unique('tipo_becas','nombre_tipo_beca')->ignore($this->tipobecas)],
            'descripcion' => ['required', 'max:150'],
            'dcto' => ['numeric','between:0,100'],
            'estado' => [],
        ];
    }
}
