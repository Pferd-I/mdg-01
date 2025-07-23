<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCursoRequest;
use App\Models\Curso;

class CursoController extends Controller{
    public function update(CreateCursoRequest $request, Curso $curso){
        $curso->update($request->validated());
    }
}
