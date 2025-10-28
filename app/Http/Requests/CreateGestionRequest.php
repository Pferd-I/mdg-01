<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateGestionRequest extends FormRequest{
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
            'unique' => 'Esta gestión ya existe.',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array{
        return [
            'gestion' => ['required', Rule::unique('gestions','gestion')->ignore($this->gestion)],
            'monto' => [],
            'presente' => [],
            'estado' => [],
        ];
    }
}
