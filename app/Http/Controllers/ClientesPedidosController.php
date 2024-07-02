<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetallesPedido;
use App\Models\EstadoPedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientesPedidosController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            $pedidos = DetallesPedido::with('pedido.cliente')->get();
            $estados = EstadoPedido::all();
            return View::make('pedidos.index', compact('pedidos', 'estados'));
        } else {
            return redirect()->to('/');
        }
    }
    public function editar($id)
    {
        if (Auth::check()) {
            $pedidos = DetallesPedido::find($id);
            $estados = EstadoPedido::all();
            return View::make('estadoPedido.edit', compact('pedidos', 'estados'));
        }
    }

    public function editEstado(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Encuentra el detalle del pedido por su ID para obtener el id_pedido
            $detallePedido = DetallesPedido::findOrFail($id);
            $idPedido = $detallePedido->id_pedido;
            $nuevoIdEstado = $request->input('idEstado');

            // Actualiza el idEstado para todos los registros que tienen ese id_pedido
            DetallesPedido::where('id_pedido', $idPedido)->update(['idEstado' => $nuevoIdEstado]);

            DB::commit();

            return response()->json([
                'mensaje' => 'Estado actualizado con éxito',
                'idnotificacion' => 1,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'mensaje' => 'Ocurrió un error al actualizar',
                'idnotificacion' => 2,
                'error' => $e->getMessage()
            ]);
        }
    }
}
