<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class productosController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            $productos = Producto::all();
            $categorias  = Categoria::all();
            return View::make('dashboard', compact('productos', 'categorias'));
        } else {
            return redirect()->to('/');
        }
    }



    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|unique:productos,nombre|max:255',
            ], ['nombre.unique' => 'El producto ya existe']);

            if ($validator->fails()) {
                return response()->json([
                    'mensaje' => $validator->errors()->first(),
                    'idnotificacion' => 3
                ]);
            }

            DB::beginTransaction();
            $producto = new Producto();
            $producto->nombre = $request->input('nombre');
            $producto->descripcion = $request->input('descripcion');
            $producto->cantidad = $request->input('cantidad');
            $producto->precio_normal = $request->input('p_normal');
            $producto->precio_rebajado = $request->input('p_rebajado');
            $producto->id_categoria = $request->input('categoria');
            $producto->save(); // Guardar para obtener el ID.

            if ($request->hasFile('foto')) {
                $nuevoNombreFotoProducto = $producto->id . "_foto_producto." . $request->file('foto')->getClientOriginalExtension();
                $producto->foto = $request->file('foto')->storeAs('fotografias', $nuevoNombreFotoProducto, 'public');
                $producto->save(); 
            }
            // dd($producto);
            DB::commit();
            return response()->json([
                'mensaje' => 'Producto guardado',
                'idnotificacion' => 1
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'mensaje' => 'Error al guardar',
                'idnotificacion' => 2
            ]);
        }
    }
}
