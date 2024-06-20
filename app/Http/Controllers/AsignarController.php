<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $user->role()->sync($request->roles);
            return redirect()->route('usuario.rol', $user);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $roles = Role::all(); // trae todos los roles que se hayan creado para poder asignar
            return view::make('admin.UserPermiso', compact('user', 'roles'));
        } else {
            return redirect()->to('/');
        }
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
        if (Auth::check()) {
            $user = User::find($id);
            $user->roles()->sync($request->roles); 
            return redirect()->route('usuarios.index', $user);
        } else {
            return redirect()->to('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check()) {
            try {
                DB::beginTransaction();
                $rol = Role::findOrFail($id);
                // $rol->estado = 0;
                // dd( $rol );
                $rol->delete();

                DB::commit();

                return response()->json([
                    'mensaje' => 'Eliminado con éxito',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al eliminar: ' . $e->getMessage(),
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }
}
