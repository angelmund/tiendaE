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
     
            $categorias = DB::table('categorias')->get();
            $productos = Producto::all();
            return View::make('store.index', compact('productos','categorias'));
        
    }

    public function carrito(){
       
            return View::make('store.carrito');
       
    }
}
