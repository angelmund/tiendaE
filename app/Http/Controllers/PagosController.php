<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\controllers\QueryException;
use App\Models\Cheque;
use Illuminate\Http\Request;
use App\Models\Inscripcione;
use App\Models\Pago;
use App\Models\Proyecto;
use App\Models\User;
use Exception;
use Luecano\NumeroALetras\NumeroALetras;

class PagosController extends Controller
{
    //muestra la lista de pagos
    public function index()
    {
        if (Auth::check()) {
            $pagos = Pago::orderBy('fecha', 'desc')->get();
            return view::make('pagos.listaPagos', compact('pagos'));
        } else {
            return redirect()->to('/');
        }
    }

    public function formulario($id)
    {
        if (Auth::check()) {
            $inscripcion = Inscripcione::find($id);
            return view::make('pagos.altaPagos', compact('inscripcion'));
        } else {
            return redirect()->to('/');
        }
    }
    //muestra la lista de cheques
    public function Cheques()
    {
        if (Auth::check()) {
            // Obtener todos los cheques, activos e inactivos
            $cheques = Cheque::orderBy('fecha', 'desc')->get();

            // Obtener todos los pagos, activos e inactivos
            $pagos = Pago::orderBy('fecha', 'desc')->get();

            // Calcular la suma de los montos de los cheques activos
            $totalMontoCheques = $cheques->where('estado', 1)->sum('monto');

            // Calcular la suma de los montos de los pagos activos
            $totalMontoPagos = $pagos->where('estado', 1)->sum('monto');

            // Calcular el total mostrando la diferencia entre los montos de pagos y cheques
            $mostrarTotal = $totalMontoPagos - $totalMontoCheques;

            //cantidad de cheques
            $sumaCheques = $cheques->count();
            $sumaPagos = $pagos->count();

            $proyectos = Proyecto::pluck('nombre');
            $inscripciones = Inscripcione::pluck('nombre_completo', 'id');
            $usuario = User::pluck('name');

            return view('cheques.listaCheques', compact('cheques', 'proyectos', 'inscripciones', 'usuario', 'pagos', 'totalMontoPagos', 'mostrarTotal', 'sumaCheques', 'sumaPagos'));
        } else {
            return redirect()->to('/');
        }
    }

    public function nuevoIngreso(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'numeroChequePago' => 'required_if:conceptoPago,cheque',
                'NumeroCuentaBancaria' => 'required_if:conceptoPago,cheque',
                'referencia' => 'required',
                'monto' => 'required|numeric',
            ], [
                'numeroChequePago.required_if' => 'El campo es requerido',
                'NumeroCuentaBancaria.required_if' => 'El campo es requerido',
                'referencia.required' => 'El campo es requerido',
                'monto.required' => 'El campo es requerido',
                'monto.numeric' => 'El campo debe ser numérico',
            ]);

            try {
                // dd($request->all());
                DB::beginTransaction();

                $conceptoPago = $request->input('conceptoPago');
                $id_cliente = $request->input('id_cliente');

                // Obtener la suma de los pagos realizados por el cliente
                $sumaPagos = Pago::where('id_cliente', $id_cliente)->sum('monto');

                if ($conceptoPago === 'pago') {
                    // Guardar en la tabla de pagos 
                    $pago = new Pago();
                    $pago->fecha = \Carbon\Carbon::now();
                    $pago->hora = Carbon::now()->toTimeString();
                    $pago->monto = $request->input('monto');
                    $pago->referencia_pago  = $request->input('referencia');
                    $pago->descripcion = $request->input('observaciones');
                    $pago->id_cliente = $id_cliente;
                    $pago->id_proyecto = $request->input('id_proyecto');
                    $pago->id_usuario = Auth::id();
                    $pago->estado = 1;

                    $pago->save();

                    DB::commit();

                    return response()->json([
                        'mensaje' => 'Pago agregado con éxito',
                        'idnotificacion' => 1,
                        'pagoId' => $pago->id // Agrega el ID del registro guardado
                    ]);
                } elseif ($conceptoPago === 'cheque') {
                    // Buscar un cheque con el mismo número
                    $chequeExistente = Cheque::firstWhere('numero_cheque', $request->input('numeroChequePago'));

                    if ($chequeExistente) {
                        // El número de cheque ya existe
                        return response()->json([
                            'mensaje' => 'El número de cheque ya existe.',
                            'idnotificacion' => 5
                        ]);
                    } elseif ($sumaPagos === 0) {
                        // El cliente no tiene pagos registrados
                        return response()->json([
                            'mensaje' => 'El cliente no tiene pagos registrados.',
                            'idnotificacion' => 4
                        ]);
                    } elseif ($request->input('monto') > $sumaPagos) {
                        // El monto del cheque supera el total de los pagos realizados por el cliente
                        return response()->json([
                            'mensaje' => 'El monto del cheque excede el saldo actual disponible del cliente. Por favor, ingrese un monto que no supere el saldo actual.',
                            'idnotificacion' => 2
                        ]);
                    } else {
                        // Guardar el cheque
                        $cheque = new Cheque();
                        $cheque->fecha = \Carbon\Carbon::today();
                        $cheque->hora = \Carbon\Carbon::now()->format('H:i:s');
                        $cheque->numero_cheque = $request->input('numeroChequePago');
                        $cheque->monto = $request->input('monto');
                        $cheque->numero_cuentabancaria = $request->input('NumeroCuentaBancaria');
                        $cheque->id_cliente = $id_cliente;
                        $cheque->id_proyecto = $request->input('id_proyecto');
                        $cheque->id_usuario = Auth::id();
                        $cheque->save();
                        DB::commit();

                        return response()->json([
                            'mensaje' => 'Cheque agregado con éxito',
                            'idnotificacion' => 1
                        ]);
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al guardar',
                    'idnotificacion' => 3
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function formIngreso()
    {
        if (Auth::check()) {

            $inscripciones = Inscripcione::all();
            $proyectos = Proyecto::pluck('nombre');
            $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');

            return view::make('pagos.altaForm', compact('inscripciones', 'selectclaveproyecto', 'proyectos'));
        } else {
            return redirect()->to('/');
        }
    }
    //obtiene la relación del nombre al seleccionar el folio (id) de mi inscripción en mi vista 
    public function getNombreInscripcion($id = 0)
    {
        if ($id == 0) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        } else {
            $inscripcion = Inscripcione::with(['proyecto' => function ($query) {
                $query->withDefault([
                    'nombre' => 'No asignado',
                    'id' => 0
                ]);
            }])->select('id', 'nombre_completo', 'clave_proyecto')->where('id', $id)->first();

            if ($inscripcion) {
                $cheques = $inscripcion->cheques()->where('estado', 1)->get();
                $totalMontoCheques = $cheques->sum('monto'); // Sumar los montos de los cheques

                $pagos = $inscripcion->pagos()->where('estado', 1)->get();
                $totalMontoPagos = $pagos->sum('monto'); // Sumar los montos de los pagos

                $mostrarTotal = $totalMontoPagos - $totalMontoCheques; // Calcular el total mostrando la diferencia entre los montos de pagos y cheques

                return response()->json([
                    'id' => $inscripcion->id,
                    'nombre_completo' => $inscripcion->nombre_completo,
                    'nombre_proyecto' => $inscripcion->proyecto->nombre, // Obtener el nombre del proyecto a través de la relación
                    'id_proyecto' => $inscripcion->proyecto->id, // Obtener el id del proyecto a través de la relación
                    // 'total_cheques' => $totalMontoCheques,
                    // 'total_pagos' => $totalMontoPagos,
                    'monto' => $mostrarTotal
                ]);
            } else {
                return response()->json(['mensaje' => 'Registro no encontrado'], 404);
            }
        }
    }

    // Termina obtiene la relación del nombre al seleccionar el folio (id) de mi inscripción en mi vista 

    public function formatoPago($id)
    {
        // Recuperar el registro de la base de datos usando el ID proporcionado
        $pago = Pago::find($id);
        $cheque = Cheque::find($id);

        if ($pago) {
            $transaccion = $pago;
            $tipo = 'pago';
        } elseif ($cheque) {
            $transaccion = $cheque;
            $tipo = 'cheque';
        } else {
            // Manejar el caso cuando el pago o cheque no existe
            return redirect()->back()->with('error', 'La transacción no existe.');
        }

        $proyecto = Proyecto::pluck('nombre');

        // Instanciar con NumeroALetras para pasar del número a como se escribe
        $formatter = new NumeroALetras();

        // Convertir el número a palabras
        $importeEnPalabras = $transaccion->monto == 0 ? 'Monto no especificado' : $formatter->toWords($transaccion->monto);

        // Convertir la fecha a un objeto Carbon
        $fecha_deposito = Carbon::parse($transaccion->fecha);

        // Formatea la fecha en D-m-y
        $fecha_formateada = $fecha_deposito->isoFormat('dddd, D [de] MMMM [del] YYYY');

        return view('pagos.formatoPdf', compact('importeEnPalabras', 'fecha_formateada', 'transaccion', 'proyecto', 'tipo'));
    }

    //cancelar cheque
    public function cancelarCheque($id)
    {
        if (Auth::check()) {

            if (Auth::check()) {
                DB::beginTransaction();
                try {
                    $cheque = Cheque::FindOrFail($id);
                    $cheque->estado = 0;
                    $cheque->save();
                    DB::commit();
                    return response()->json([
                        'mensaje' => 'Pago cancelado con éxito',
                        'idnotificacion' => 5
                    ]);
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'mensaje' => 'Error al cancelar',
                        'idnotificacion' => 8
                    ]);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    //cancelar Pago
    public function cancelarPago($id)
    {
        if (Auth::check()) {

            if (Auth::check()) {
                DB::beginTransaction();
                try {
                    $pago = Pago::FindOrFail($id);
                    $pago->estado = 0;
                    $pago->save();
                    DB::commit();
                    return response()->json([
                        'mensaje' => 'Pago cancelado con éxito',
                        'idnotificacion' => 5
                    ]);
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'mensaje' => 'Error al cancelar',
                        'idnotificacion' => 8
                    ]);
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    //Mostrar pagos por Folio de persona 
    public function mostrarPagoPersona($tipo, $id)
    {
        if (Auth::check()) {
            if ($tipo === 'cheque') {
                $cheques = Cheque::where('id_cliente', $id)->get();
                $totalMontoCheques = $cheques->sum('monto');
                return view('cheques.pagosPersonas', compact('cheques', 'totalMontoCheques'));
            } elseif ($tipo === 'pago') {
                $pagos = Pago::where('id_cliente', $id)->get();
                $totalMontoPagos = $pagos->sum('monto');
                return view('cheques.pagosPersonas', compact('pagos', 'totalMontoPagos'));
            } else {
                // Manejar caso de tipo de pago no válido, por ejemplo, redireccionar a una página de error
                return response()->json([
                    'mensaje' => 'Pago inexistente',
                    'idnotificacion' => 1
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }


    public function Pagos($id)
    {
        if (Auth::check()) {
            // Obtener la inscripción correspondiente al ID proporcionado
            $inscripcion = Inscripcione::findOrFail($id);
            $cheques = $inscripcion->cheques;
            // Obtener los cheques asociados a la inscripción
            $cheque = $inscripcion->cheques()->where('estado', 1)->get();
            $numCheques = $cheque->count(); // Contar la cantidad de cheques
            $totalMontoCheques = $cheque->sum('monto'); // Sumar los montos de los cheques

            $pagos = $inscripcion->pagos;
            // Obtener los pagos asociados a la inscripción
            $pago = $inscripcion->pagos()->where('estado', 1)->get();
            $numPagos = $pago->count(); // Contar la cantidad de pagos
            $totalMontoPagos = $pago->sum('monto'); // Sumar los montos de los pagos

            // Calcular el total mostrando la diferencia entre los montos de pagos y cheques
            $mostrarTotal = $totalMontoPagos - $totalMontoCheques;

            // Sumar la cantidad de cheques y pagos
            $total = $numCheques + $numPagos;

            return view('cheques.pagosPersonas', compact('cheques', 'numCheques', 'numPagos', 'totalMontoCheques', 'pagos', 'numPagos', 'total', 'inscripcion', 'mostrarTotal'));
        } else {
            return redirect()->to('/');
        }
    }


    public function MesChequeGanacias($year = null)
    {
        // Si no se proporciona un año, usar el año actual
        if ($year === null) {
            $year = date('Y');
        }

        // Inicializa un array para almacenar los resultados
        $results = [];

        // Itera sobre cada mes del año
        for ($month = 1; $month <= 12; $month++) {
            // Obtener todos los pagos para el mes y año actual que tienen un estado de 1
            $payments = Inscripcione::where('estado', 1)
                ->whereYear('fecha_registro', $year)
                ->whereMonth('fecha_registro', $month)  // Cambiado a 'fecha_registro'
                ->get();

            // Suma los montos de los pagos
            $totalPayments = $payments->sum('importe');

            // Obtenertodos las inscripciones activos para el mes y año actual
            $checks = Inscripcione::where('estado', 1)
                ->whereYear('fecha_registro', $year)
                ->whereMonth('fecha_registro', $month)
                ->get();

            // Suma los montos de las inscripciones
            $totalChecks = $checks->sum('monto');

            // Resta la suma de las inscripciones de los importes
            $total = $totalPayments - $totalChecks;

            // Almacena el total en el array de resultados
            $results[] = [
                'mes' => $month,
                'tImporte' => $payments->count(),
                'ganancia' => $total
            ];
        }

        // Devuelve los resultados como un objeto JSON
        return response()->json($results);
    }



    public function MesPagos($currentYear = null)
    {
        // Obtener el año actual
        // Si no se proporciona un año, usar el año actual
        if ($currentYear === null) {
            $currentYear = date('Y');
        }


        // Inicializa un array para almacenar los resultados
        $results = [];

        // Itera sobre cada mes del año
        for ($month = 1; $month <= 12; $month++) {
            // Obtener todos los pagos para el mes y año actual que tienen un estado de 1
            $payments = Pago::where('estado', 1)
                ->whereYear('fecha', $currentYear)
                ->whereMonth('fecha', $month)
                ->get();

            // Suma los montos de los pagos
            $totalPayments = $payments->sum('monto');

            // Almacena el total en el array de resultados
            $results[] = [
                'mes' => $month,
                'nPagos' => $payments->count(),
                'totalPagos' => $totalPayments,
            ];
        }

        // Devuelve los resultados como un objeto JSON
        return response()->json($results);
    }
}
