<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CreateGestionMensController;
use App\Http\Controllers\PpffController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevokePfRoleController;
use App\Http\Controllers\RevokePfUserController;
use App\Http\Controllers\RevokeRfUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MensualidadController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\PlantelController;
use App\Http\Controllers\TipoBecaController;
use App\Models\Plantel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


/*Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', [MainController::class, 'index'] )->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/aulas',AulaController::class);
    Route::resource('/cursos',CursoController::class);
    //Estudiantes
    Route::resource('/estudiantes',EstudianteController::class);
    Route::get('/estudiantes/{id}/get', [EstudianteController::class, 'getEstudiante'])->name('estudiantes.get');
    Route::post('/estudiantes/{id}/{par}/add-padre', [EstudianteController::class, 'addPpff'])->name('estudiantes.addPpff');
    Route::delete('/estudiantes/{id_estudiante}/padre/{id_ppff}', [EstudianteController::class, 'removePpff'])->name('estudiantes.removePpff');
    Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::put('/estudiantes/{id}/inhabilitar', [EstudianteController::class, 'inhabilitar'])
            ->name('estudiantes.inhabilitar');

    Route::resource('/mensualidades',MensualidadController::class);
    Route::resource('/nivels',NivelController::class);
    Route::resource('/paralelos',ParaleloController::class);
    Route::resource('/permissions',PermissionController::class);

    //Plantel
    Route::resource('plantel', PlantelController::class);
    Route::get('/plantel/{id}/get', [PlantelController::class, 'getPlantel'])->name('plantel.get');
    Route::delete('/plantel/{id_plantel}/cargo/{id_cargo}', [PlantelController::class, 'removeCargo'])->name('plantel.removeCargo');
    Route::put('/plantel/{id}', [PlantelController::class, 'update'])->name('plantel.update');

    Route::get('/plantel/{id}/usuario', [PlantelController::class, 'getUsuario'])->name('plantel.getUsuario');
    Route::post('/plantel/{id}/usuario', [PlantelController::class, 'assignUsuario'])->name('plantel.assignUsuario');
    Route::delete('/plantel/{id}/usuario', [PlantelController::class, 'removeUsuario'])->name('plantel.removeUsuario');


    Route::post('/plantel/{id}/addCargo', [PlantelController::class, 'addCargo'])->name('plantel.addCargo');
    //Ppffs
    Route::resource('/ppffs',PpffController::class);
    Route::get('/ppffs/{id}/get', [PpffController::class, 'getPpff'])->name('ppffs.get');

    Route::resource('/roles',RoleController::class);
    Route::resource('/tipobecas',TipoBecaController::class);
    Route::resource('/users',UserController::class);
    Route::get('/gestion&mensualidades', CreateGestionMensController::class)
            ->name('gestion.mensualidades.create');
    Route::delete('/roles/{role}/permissions/{permission}', RevokePfRoleController::class)
            ->name('roles.permissions.revoke');
    Route::delete('/user/{user}/roles/{role}', RevokeRfUserController::class)
            ->name('users.roles.revoke');
    Route::delete('/user/{user}/permissions/{permission}', RevokePfUserController::class)
            ->name('users.permissions.revoke');

    Route::get('/gestiones/{gestion}/mensualidades', [MensualidadController::class, 'mensualidades'])
            ->name('gestiones.mensualidades');
    //Route::resource('/editnivel',EditNivelController::class)->name(,'nivels.edit');
});

Route::middleware('auth')->prefix('/main')->group(function(){
    Route::get('/', [MainController::class, 'index'])->name('main.index');
});

Route::resource('/posts',PostController::class);

require __DIR__.'/auth.php';


