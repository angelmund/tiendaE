<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class tiendavirtualController extends Controller
{
    public function index(){
        if (Auth::check()) {
            $categorias = DB::table('categorias')->get();
            $productos = Producto::all();
            return View::make('store.index', compact('productos'));
        } else {
            return redirect()->to('/');
        }
    
    }

    public function carrito(){
        if (Auth::check()) {
            return View::make('store.carrito');
        } else {
            return redirect()->to('/');
        }
    }
}
