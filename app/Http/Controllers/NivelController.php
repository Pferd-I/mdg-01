<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\CreateNivelRequest;
use App\Http\Resources\PostResource;
use App\Models\Nivel;

class NivelController extends Controller{
    public function update(CreateNivelRequest $request, Nivel $nivel){
        $nivel->update($request->validated());
        return back()->with('showModal',false);
    }
}
