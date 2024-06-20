<?php

namespace App\Http\Controllers;

use App\Models\Inscripcione;
use App\Models\Pago;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class contadorRegistrosController extends Controller
{
    public function numInscripciones()
    {
        // // Obtener las inscripciones
        // $inscripcion = Inscripcione::where('estado', 1)->get();
        // $numinscripciones = $inscripcion->count(); 

        // //Obtener num de Proyectos
        // $proyectos = Proyecto::where('estado', 1)->get();
        // $numproyectos = $proyectos->count();

        // //Obtener num de Pagos
        // $pagos = Pago::where('estado', 1)->get();
        // $numpagos = $pagos->count();

        //Obtener num de Usuarios
        $usuarios = User::where('estado', 1)->get();
        $numusuarios = $usuarios->count();

        return view('dashboard', compact('numusuarios'));
    }
}
