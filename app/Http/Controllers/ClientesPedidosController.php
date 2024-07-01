<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetallesPedido;
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
            return View::make('pedidos.index', compact('pedidos'));
        } else {
            return redirect()->to('/');
        }
    }
}
