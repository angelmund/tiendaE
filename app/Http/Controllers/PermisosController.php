<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $permisos = Permission::all();
            return view::make('admin.Permisos', compact('permisos'));
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
            // 'nombredelcampo' => 'required | email | unique:tabla', 
            'nombre' => 'required','unique:permissions,name',

        ], [
            'nombre.unique' => 'El permiso ya existe.'
        ]);
        if (Auth::check()) {

            try {
                DB::beginTransaction();
                $permission = Permission::create(['name' => $request->input('nombre')]);
                DB::commit();

                return response()->json([
                    'mensaje' => 'Permiso guardado con éxito',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
