<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\controllers\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function usuarios()
    {
        if (Auth::check()) {
            $usuarios = User::all();
            return view::make('admin.index', compact('usuarios'));
        } else {
            return redirect()->to('/');
        }
    }

    public function create()
    {
        if (Auth::check()) {
            $roles = Role::all(); // trae todos los roles que se hayan creado para poder asignar
            return view::make('admin.create', compact('roles'));
        } else {
            return redirect()->to('/');
        }
    }

    public function nuevoUsuario(Request $request)
    {
        if (Auth::check()) {

            try {


                $validator = Validator::make($request->all(), [
                    'email' => 'unique:users,email|max:50',
                    'nombre' => 'string|max:255',
                    'rol' => 'exists:roles,id',
                ], ['email.unique' => 'El email ya ha sido tomado']);

                if ($validator->fails()) {
                    return response()->json([
                        'mensaje' => $validator->errors()->first(),
                        'idnotificacion' => 3
                    ]);
                }
                DB::beginTransaction();
                // dd($request->all());
                $usuario = new User();
                $usuario->name = $request->input('nombre');
                $usuario->email = $request->input('email');
                $usuario->email_verified_at = now();
                $usuario->password = bcrypt($request->input('password'));

                $usuario->estado = 1; // Estado activo
                // dd($usuario);
                $usuario->save();

                // Asigna el rol al usuario
                $rol = Role::findOrFail($request->input('rol'));
                $usuario->assignRole($rol);

                DB::commit();

                return response()->json([
                    'mensaje' => 'Usuario agregado con éxito',
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

    public function asignarRolEdit($id)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $roles = Role::all(); // trae todos los roles que se hayan creado para poder asignar
            return view::make('admin.UserPermiso', compact('user', 'roles'));
        } else {
            return redirect()->to('/');
        }
    }

    public function eliminarUsuario($id)
    {
        if (Auth::check()) {
            try {
                DB::beginTransaction();
                $user = User::findOrFail($id);
                $user->estado = 0;
                // dd( $user );
                $user->save();

                DB::commit();

                return response()->json([
                    'mensaje' => 'Eliminado con éxito',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al eliminar',
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }

    // public function asignarRolGuardar(Request $request, $id)
    // {
    //     if (Auth::check()) {
    //         $user = User::find($id);
    //         $user->role()->sync($request->roles); // trae todos los roles que se hayan creado para poder asignar
    //         // return view::make('admin.UserPermiso', compact('user', 'roles'));
    //     } else {
    //         return redirect()->to('/');
    //     }
    // }
}
