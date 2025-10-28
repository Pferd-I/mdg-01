<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MensualidadResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'nro_mes' => $this->nro_mes,
            'nombre_mes' => $this->nombre_mes,
            'gestion' => $this->gestion,
            'monto' => $this->monto,
            'estado' => $this->estado,
        ];
    }
}
