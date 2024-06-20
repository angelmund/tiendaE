<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class categoriasController extends Controller
{
    public function index(){
        if (Auth::check()) {
            // $categorias = DB::table('categorias')->get();
            $categorias = Categoria::all();
            return View::make('categorias.index', compact('categorias'));
        } else {
            return redirect()->to('/');
        }
    
    }
}
