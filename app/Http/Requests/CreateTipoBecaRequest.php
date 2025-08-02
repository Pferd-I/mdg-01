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
            'required'=> 'Se requiere un nombre para el campo.',
            'max' => 'Por favor, coloque un nombre más corto.',
            'unique' => 'Ese curso ya existe.',
            'between' => 'El valor está fuera del rango.',
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
            'nombre_tipo_beca' => [],
            'descripcion' => [],
            'dcto' => [],
            'estado' => [],
        ];
    }
}
