<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class categoriasController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // $categorias = DB::table('categorias')->get();
            $categorias = Categoria::all();
            return View::make('categorias.index', compact('categorias'));
        } else {
            return redirect()->to('/');
        }
    }

    public function create()
    {
        if (Auth::check()) {
            return View::make('categorias.create');
        } else {
            return redirect()->to('/');
        }
    }

    public function store(Request $request)
    {
        if (Auth::check()) {

            try {

                $validator = Validator::make($request->all(), [
                    'nombre' => 'required|unique:categorias,categoria|max:50',
                ], ['nombre.unique' => 'La categoría ya existe']);
    
                if ($validator->fails()) {
                    return response()->json([
                        'mensaje' => $validator->errors()->first(),
                        'idnotificacion' => 3
                    ]);
                }
                DB::beginTransaction();
                $categoria = new Categoria();
                $categoria->categoria = request('nombre');
                // dd($categoria);
                $categoria->save();
                DB::commit();
                return response()->json([
                    'mensaje' => 'Categoría guardada',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al guardar',
                    'idnotificacion' => 2
                ]);
            };
        } else {
            return redirect()->to('/');
        }
    }

    public function edit($id){
        if (Auth::check()) {
            $categorias = Categoria::find($id);
            return View::make('categorias.edit', compact('categorias'));
        } else {
            return redirect()->to('/');
        }
    }

    public function actualizar($id) {
        if (Auth::check()) {
            try {
                $validator = Validator::make(request()->all(), [
                    'nombre' => ['required', Rule::unique('categorias', 'categoria')->ignore($id)],
                ], ['nombre.unique' => 'La categoría ya existe']);
    
                if ($validator->fails()) {
                    return response()->json([
                        'mensaje' => $validator->errors()->first(),
                        'idnotificacion' => 3
                    ]);
                }
                DB::beginTransaction();
                $categoria = Categoria::find($id);
                $categoria->categoria = request('nombre');
                $categoria->save();
                DB::commit();
                return response()->json([
                    'mensaje' => 'Categoría actualizada',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al actualizar',
                    'idnotificacion' => 2
                ]);
            };
        } else {
            return redirect()->to('/');
        }
    }
}
