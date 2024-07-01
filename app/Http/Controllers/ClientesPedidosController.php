<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetallesPedido;
use App\Models\EstadoPedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::check()){
            $pedidos = DetallesPedido::find($id);
            $estados = EstadoPedido::all();
            return View::make('estadoPedido.edit', compact('pedidos', 'estados'));
        }
    }

    public function editEstado() {
        $pedido = DetallesPedido::find(request('id'));
        $pedido->idEstado = request('estado');
        $pedido->save();
        return redirect()->route('pedidos.index');
    }
}
