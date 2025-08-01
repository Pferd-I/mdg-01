<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoBecaResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'nombre_tipo_beca' => $this->nombre_tipo_beca,
            'descripcion' => $this->descripcion,
            'coeficiente' => $this->coeficiente,
            'estado' => $this->estado,
        ];
    }
}
