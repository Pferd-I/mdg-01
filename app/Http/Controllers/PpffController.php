<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\PpffResource;
use App\Models\Ppff;
use Inertia\Inertia;
use Inertia\Response;

class PpffController extends Controller{
    public function index(): Response{
        return Inertia::render('Admin/Ppffs/PpffIndex', [
            'ppffs' => PpffResource::collection(Ppff::all())
        ]);
    }
    public function create(): Response{
         return Inertia::render('Admin/Ppffs/Create');
    }

    public function edit(string $id){
        $ppff = Ppff::with('contactos', 'estudiantes')->findOrFail($id);
        return Inertia::render('Admin/Ppffs/Edit',[
            'ppff' => $ppff,
        ]);
    }

    public function update(Request $request, $id){
        $ppff = Ppff::findOrFail($id);

        $validated = $request->validate([
            'cionit' => 'required|string',
            'nombre' => 'required|string',
            'contactos' => 'array',
            'contactos.*.telefono' => 'nullable|string',
            'contactos.*.direccion' => 'nullable|string',
        ]);

        $ppff->update($validated);
        $ppff->contactos()->delete();

        if (!empty($validated['contactos'])) {
            foreach ($validated['contactos'] as $contacto) {
                $ppff->contactos()->create($contacto);
            };
        };
        return redirect()->route('ppffs.index')->with('success', 'Datos actualizados correctamente.');
    }

    public function store(Request $request): RedirectResponse{
        Ppff::create( $request->validate([
            'nombre' => 'required|string|max:255',
            'cionit' => 'required|string|max:20|unique:'.Ppff::class,
            'direccion' => 'string|max:255',
            //'telf' => 'required|numeric',
        ]));
        /*$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncPermissions($request->input('permissions.*.name'));
        $user->syncRoles($request->input('roles.*.name'));*/
        return to_route('ppffs.index');
    }
}
