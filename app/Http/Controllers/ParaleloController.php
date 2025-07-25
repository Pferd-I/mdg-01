<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParaleloRequest;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class ParaleloController extends Controller{
    public function store(CreateParaleloRequest $request){
        Paralelo::create($request->validated());
    }
    public function update(CreateParaleloRequest $request, Paralelo $paralelo){
        $paralelo->update($request->validated());
    }
    public function destroy(Paralelo $paralelo){
        $paralelo->update(['estado'=> false]);
    }
}
