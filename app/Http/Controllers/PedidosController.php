<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetallesPedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function Pedido(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validar datos entrantes
            $request->validate([
                'nombre_completo' => 'required|string|max:180',
                'email' => 'required|email|max:50',
                'telefono' => 'required|string|max:10',
                'direccion' => 'required|string|max:100',
                'productos' => 'required|json',
                'total' => 'required|numeric|min:0'
            ]);

            // Decodificar los productos
            $productos = json_decode($request->input('productos'), true);
            // dd($productos);
            $total = $request->input('total');

            // Guardar los datos del cliente
            $cliente = new Cliente();
            $cliente->nombre_completo = $request->input('nombre_completo');
            $cliente->correo = $request->input('email');
            $cliente->telefono = $request->input('telefono');
            $cliente->direccion = $request->input('direccion');
            $cliente->save();

            // Guardar los datos del pedido
            $pedido = new Pedido();
            $pedido->total = $total;
            $pedido->fecha = now();
            $pedido->id_cliente = $cliente->idCliente;
            $pedido->save();

            // Guardar los detalles del pedido
            foreach ($productos as $producto) {
                $pedidoDetalle = new DetallesPedido();
                $pedidoDetalle->cantidad = $producto['cantidad'];
                $pedidoDetalle->precio = $producto['precio'];
                $pedidoDetalle->id_producto = $producto['id'];
                $pedidoDetalle->id_pedido = $pedido->idPedido;
                $pedidoDetalle->save();

                // Restar la cantidad vendida del producto en la tabla productos
                $productoModel = Producto::find($producto['id']);
                $productoModel->cantidad -= $producto['cantidad'];
                $productoModel->save();
            }

            DB::commit();

            return response()->json([
                'mensaje' => 'Pedido realizado con éxito',
                'idnotificacion' => 1
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'mensaje' => 'Ocurrió un error al realizar el pedido',
                'idnotificacion' => 2,
                'error' => $e->getMessage()
            ]);
        }
    }
}
