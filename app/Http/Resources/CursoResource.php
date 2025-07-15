<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CursoResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'id' => $this->id,
            'grado' => $this->grado,
            'nro_grado' => $this->nro_grado,
            'id_nivel' => $this->id_nivel,
            'id_paralelo' => $this->id_paralelo,
            'gestion' => $this->gestion,
            'estado' => $this->estado,
        ];
    }
}
