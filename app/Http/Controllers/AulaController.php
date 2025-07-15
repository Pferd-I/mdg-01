<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNivelRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Resources\NivelResource;
use App\Models\Nivel;
use App\Http\Resources\ParaleloResource;
use App\Models\Paralelo;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class AulaController extends Controller{
    public function index(): Response{
        $niveles = NivelResource::collection(Nivel::all());
        $paralelos = ParaleloResource::collection(Paralelo::all());
        /*$cursosInicial = DB::table('cursos AS C')
                    ->leftJoin('nivels AS N','C.id_nivel','=','N.id')
                    ->leftJoin('paralelos As P','C.id_paralelo','=','P.id')
                    ->select('C.id','C.grado','C.nro_grado','N.nombre_nivel AS nivel','P.nombre_paralelo AS paralelo','C.gestion','C.estado')
                    ->get();*/
        $cursosInicial = $this->obtenerCurso(1);
        $cursosPrimaria = $this->obtenerCurso(2);
        $cursosSecundaria = $this->obtenerCurso(3);
        return Inertia::render('Admin/Aulas/AulaIndex',[
            'niveles' => $niveles,
            'paralelos' => $paralelos,
            'cursosInicial' => $cursosInicial,
            'cursosPrimaria' => $cursosPrimaria,
            'cursosSecundaria' => $cursosSecundaria,
            //'cursos' => CursoResource::collection(Curso::all()),
        ]);
    }
    private function obtenerCurso(int $nivel){
        return DB::table('cursos AS C')
                    ->leftJoin('nivels AS N','C.id_nivel','=','N.id')
                    ->leftJoin('paralelos As P','C.id_paralelo','=','P.id')
                    ->select('C.id','C.grado','C.nro_grado','N.nombre_nivel AS nivel','P.nombre_paralelo AS paralelo','C.gestion','C.estado')
                    ->where('N.id', '=', $nivel)
                    ->get();
        /*$cursoSeleccionado = DB::table('cursos AS C')
                    ->join('nivels AS N', function (JoinClause $join, $nivel){
                        $join->on('C.id_nivel', '=', 'N.id')
                        ->where('N.id', '=', $nivel);
                    });*/
    }
    /*public function NivelUpdate(CreateNivelRequest $request, string $id){
        $nivel = Nivel::find($id);
        $nivel->update([
            'nombre_nivel' => $request->nombre_nivel,
        ]);
        return back();
    }*/
    public function update(){
        return "HolasBolas";
    }
    /*public function update(CreateNivelRequest $request, Nivel $nivel){
        $nivel->update($request->validated());
        return to_route('aulas.index');
    }*/
    /*public function update(CreatePostRequest $request, Post $post): RedirectResponse{
        $post->update($request->validated());
        return to_route('posts.index');
    }*/
}
