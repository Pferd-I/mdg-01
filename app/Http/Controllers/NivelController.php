<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNivelRequest;
use App\Models\Nivel;

class NivelController extends Controller{
    public function update(CreateNivelRequest $request, Nivel $nivel){
        $nivel->update($request->validated());
    }
}
