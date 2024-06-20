<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $roles = Role::all();
            return view::make('admin.Roles', compact('roles'));
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required','unique:roles,name',
        ], [
            'nombre.unique' => 'El rol ya existe.'
        ]);

        if (Auth::check()) {
            try {
                DB::beginTransaction();
                $role = Role::create(['name' => $request->input('nombre')]);
                DB::commit();

                return response()->json([
                    'mensaje' => 'Rol guardado con éxito',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al guardar: ' . $e->getMessage(),
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permisos =  Permission::all(); //devuleve todos los permisos que tenga el rol
        return view('admin.RolPermiso', compact('role', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permisos);
        return redirect()->route('usuarios.roles.edit', ['role' => $role->id]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
