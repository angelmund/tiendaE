<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\controllers\QueryException;
use Illuminate\Http\Request;
use App\Models\Inscripcione;
use App\Models\Proyecto;
use Exception;
use Dompdf\Dompdf;
use PDF;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;

class InscripcionesController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $inscripciones = Inscripcione::orderBy('fecha_registro', 'desc')->get();
            $proyectos = Proyecto::pluck('nombre');
            $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');
            // $proyecto = Proyecto::select('clave_proyecto', 'nombre')->where('id', 'clave_proyecto')->first();

            // if ($proyecto) {
            //     return response()->json([
            //         'clave_proyecto' => $proyecto->clave_proyecto,
            //         'nombre_proyecto' => $proyecto->nombre,
            //     ]);
            // } else {
            //     return response()->json(['mensaje' => 'Proyecto no encontrado'], 404);
            // }
            // return response()->json(Inscripcione::all());

            return View::make('incripciones.index', compact('inscripciones', 'proyectos', 'selectclaveproyecto')); //
        } else {
            return redirect()->to('/');
        }
    }


    public function vistaCrear()
    {
        if (Auth::check()) {
            // $medidas= Medida::where('estado', 1)->get();
            //$inscripciones = Inscripcione::all();
            $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');
            //$selectjuzgados = Ctgjuzgado::where('estatus', true)->orderBy('juzgado', 'asc')->pluck('juzgado', 'idjuzgado');
            // $selectjuzgados = []; //devuleve un arreglo vacío

            return View::make('incripciones.create', compact('selectclaveproyecto')); //
        } else {
            return redirect()->to('/');
        }
    }
    // public function vistaEdit()
    // {
    //     if(Auth::check()){
    //         $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');
    //         return View::make('incripciones.edit', compact('selectclaveproyecto')); //
    //     }else{
    //         return redirect()->to('/');
    //     }
    // }
    public function crearInscripcion(Request $request)
    {
        if (Auth::check()) {
            // Obtener el nombre completo del cliente
            $nombreCompleto = strtoupper($request->input('nombre'));

            // Validar que el cliente no esté asignado a otro proyecto
            $cliente = Inscripcione::where('nombre_completo', $nombreCompleto)
                ->whereNotNull('clave_proyecto')
                ->first();

            if ($cliente) {
                return response()->json([
                    'mensaje' => 'La persona que desea registrar ya está asignada a un proyecto.',
                    'idnotificacion' => 3 // Esto indica que es un error de validación
                ], 422); // Devuelve el código de estado HTTP 422 para indicar una validación fallida
            }

            $request->validate([
                'nombre' => 'required',
                'direccion' => 'required',
                'alcaldia' => 'required',
                'telefono' => 'required|numeric',
                'concepto' => 'required',
                'importeInscripcion' => 'required|numeric',
                'noSolicitud' => 'required',
                'fechaDeposito' => 'required',
            ], [
                'nombre.required' => 'El campo nombre completo es requerido',
                'direccion.required' => 'El campo dirección es requerido',
                'alcaldia.required' => 'El campo alcaldía es requerido',
                'telefono.required' => 'El campo teléfono es requerido',
                'telefono.numeric' => 'El campo teléfono debe ser numérico',
                'concepto.required' => 'El campo concepto es requerido',
                'importeInscripcion.required' => 'El campo Importe Inscripción es requerido',
                'importeInscripcion.numeric' => 'El campo Importe Inscripción debe ser numérico',
                'noSolicitud.required' => 'El número de solicitud es requerida',
                'fechaDeposito.required' => 'La fecha del depósito es requerida',
            ]);
            // dd($request->all());
            try {
                DB::beginTransaction();
                // dd($request->all());
                $inscripcion = new Inscripcione();
                $inscripcion->nombre_completo = strtoupper($request->input('nombre'));
                $inscripcion->direccion = $request->input('direccion');
                // $claveProyecto = $request->input('claveProyecto');


                // $proyecto = Proyecto::where('clave_proyecto', $claveProyecto)->first();


                // if (!$proyecto) {
                //     return response()->json([
                //         'mensaje' => 'Error al guardar: El proyecto con clave_proyecto ' . $claveProyecto . ' no existe.',
                //         'idnotificacion' => 3
                //     ]);
                // }

                $inscripcion->clave_proyecto = $request->input('claveProyecto');

                // $inscripcion->nombreProyecto  = $request->input('nombreProyecto');
                $inscripcion->comite = $request->input('comite');
                $inscripcion->alcaldia = $request->input('alcaldia');
                $inscripcion->telefono = $request->input('telefono');
                $inscripcion->concepto = $request->input('concepto');
                $inscripcion->importe = $request->input('importeInscripcion');
                $inscripcion->numero_solicitud = $request->input('noSolicitud');
                $inscripcion->fecha_deposito = $request->input('fechaDeposito');
                $inscripcion->fecha_registro = \Carbon\Carbon::now();
                // Genera los nuevos nombres de archivo usando el ID de inscripción
                // $nuevoNombreFotoCliente = $inscripcion->id . "foto_cliente." . pathinfo($request->file('fotoCliente')->getClientOriginalName(), PATHINFO_EXTENSION);
                // $nuevoNombreIne = $inscripcion->id . "foto_ine." . pathinfo($request->file('Ine')->getClientOriginalName(), PATHINFO_EXTENSION);

                // // Guarda las imágenes con los nuevos nombres
                // if ($request->hasFile('fotoCliente')) {
                //     $inscripcion->url_foto_cliente = $request->file('fotoCliente')->storeAs('images/photo', $nuevoNombreFotoCliente, 'public');
                // }

                // if ($request->hasFile('Ine')) {
                //     $inscripcion->url_foto_ine = $request->file('Ine')->storeAs('images/photo', $nuevoNombreIne, 'public');
                //     // dd($inscripcion);
                // }
                $inscripcion->hora_registro = date("H:i:s");
                $inscripcion->observaciones = $request->input('observaciones');
                $inscripcion->estado = 1;
                // dd($inscripcion);
                $inscripcion->save();

                DB::commit();


                // // Generar PDF
                // $pdf = PDF::loadView('incripciones.PdfIns', compact('inscripcion'));

                // // Guardar el PDF en almacenamiento local
                // $pdfPath = public_path('pdf/pdfs/') . $inscripcion->id . '.pdf';
                // $pdf->save($pdfPath);

                // // Descargar el PDF



                return response()->json([
                    'mensaje' => 'Inscripción realizada con éxito',
                    'idnotificacion' => 1,
                    'inscripcionId' => $inscripcion->id // Agrega el ID del registro guardado
                ]);

                // return response()->download($pdfPath)->setContentDisposition('attachment');
                // Después de guardar el registro, devuelve la vista
                // return view('incripciones.PdfIns', compact('inscripcion'));
            } catch (\Exception $e) {

                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al guardar',
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }
    public function mostrarFormato($id)
    {
        // Recuperar el registro de la base de datos usando el ID proporcionado
        $inscripcion = Inscripcione::find($id);

        // Instanciar con NumeroALetras para pasar del número a como se escribe
        $formatter = new NumeroALetras();

        // Convertir el número a palabras
        $importeEnPalabras = $formatter->toWords($inscripcion->importe);

        // Convertir la fecha a un objeto Carbon
        $fecha_deposito = Carbon::parse($inscripcion->fecha_deposito);

        $fecha_regist = Carbon::parse($inscripcion->fecha_registro);

        $fecha_regis = $fecha_regist->isoFormat('dddd, D [de] MMMM [del] YYYY');

        // Formatea la fecha en D-m-y
        $fecha_formateada = $fecha_deposito->isoFormat('dddd, D [de] MMMM [del] YYYY');

        // Pasar ambas variables a la vista
        return view('incripciones.PdfIns', compact('inscripcion', 'importeEnPalabras', 'fecha_formateada', 'fecha_regis'));
    }



    // public function nuevainscripcion(Request $request)
    // {
    //     if (Auth::check()) {
    //         $request->validate([
    //             // 'nombredelcampo' => 'required | email | unique:tabla', 
    //             'nombre' => 'required',
    //             'direccion' => 'required',
    //             // 'descripcion_edit' => 'required',
    //             'claveProyecto' => 'required',
    //             'nombreProyecto' => 'required',
    //             'comite' => 'required',
    //             'alcaldia' => 'required',
    //             'telefono' => 'required | numeric',
    //             'concepto' => 'required',
    //             'importeInscripcion' => 'required | numeric',
    //             'noSolicitud' => 'required',
    //             'fechaDeposito' => 'required',
    //             'fotoCliente' => 'image|mimes:jpeg,png,jpg',
    //             'Ine' => 'image|mimes:jpeg,png,jpg',
    //         ]);
    //         try {
    //             DB::beginTransaction();
    //             // dd($request);
    //             $inscripcion = new Inscripcione();
    //             $inscripcion->nombre_completo = $request->input('nombre');
    //             $inscripcion->direccion = $request->input('direccion');
    //             $inscripcion->clave_proyecto = $request->input('claveProyecto');
    //             $inscripcion->nombreProyecto  = $request->input('nombreProyecto');
    //             $inscripcion->comite = $request->input('comite');
    //             $inscripcion->alcaldia = $request->input('alcaldia');
    //             $inscripcion->telefono = $request->input('telefono');
    //             $inscripcion->concepto = $request->input('concepto');
    //             $inscripcion->importe = $request->input('importeInscripcion');
    //             $inscripcion->numero_solicitud = $request->input('noSolicitud');
    //             $inscripcion->fecha_deposito = $request->input('fechaDeposito');
    //             $inscripcion->fecha_registro = \Carbon\Carbon::now();
    //             // Genera los nuevos nombres de archivo usando el ID de inscripción
    //             $nuevoNombreFotoCliente = $inscripcion->id . "_cliente." . pathinfo($request->file('fotoCliente')->getClientOriginalName(), PATHINFO_EXTENSION);
    //             $nuevoNombreIne = $inscripcion->id . "_ine." . pathinfo($request->file('Ine')->getClientOriginalName(), PATHINFO_EXTENSION);

    //             // Guarda las imágenes con los nuevos nombres
    //             if ($request->hasFile('fotoCliente')) {
    //                 $inscripcion->url_foto_cliente = $request->file('fotoCliente')->storeAs('images/photo/', $nuevoNombreFotoCliente, 'public');
    //             }

    //             if ($request->hasFile('Ine')) {
    //                 $inscripcion->url_foto_ine = $request->file('Ine')->storeAs('images/photo/', $nuevoNombreIne, 'public');
    //             }
    //             $inscripcion->hora_registro = date("H:i:s");
    //             $inscripcion->estado = 1;
    //             $inscripcion->save();

    //             DB::commit();

    //             // Después de guardar exitosamente
    //             return response()->json([
    //                 'mensaje' => 'Inscripción realizada con éxito',
    //                 'idnotificacion' => 1
    //             ]);

    //         } catch (\Exception $e) {

    //             DB::rollback();
    //             return response()->json([
    //                 'mensaje' => 'Error al guardar: ' . $e->getMessage(),
    //                 'idnotificacion' => 2
    //             ]);
    //         } 
    //     } else {
    //         return redirect()->to('/');
    //     }
    // }

    public function getClavePoryectoRelaciones($id = 0)
    {
        if ($id == 0) {
            return response()->json(['mensaje' => 'Registro no encontrado'], 404);
        } else {
            $proyecto = Proyecto::select('clave_proyecto', 'nombre')->where('id', $id)->first();

            if ($proyecto) {
                return response()->json([
                    'clave_proyecto' => $proyecto->clave_proyecto,
                    'nombre_proyecto' => $proyecto->nombre,
                ]);
            } else {
                return response()->json(['mensaje' => 'Proyecto no encontrado'], 404);
            }
        }
    }


    // public function editInscripcion($id)
    // {
    //     if (Auth::check()) {
    //         try {

    //             if (Auth::check()) {
    //                 $proyecto = Proyecto::select('clave_proyecto', 'nombre')->where('id', $id)->first();
    //                 $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');
    //                 $inscripcion = Inscripcione::find($id);
    //                 return view('incripciones.edit', compact('proyecto', 'inscripcion', 'selectclaveproyecto'));
    //             } else {
    //                 return redirect()->to('/');
    //             }
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => $e->getMessage()], 500);
    //         }
    //     } else {
    //         return redirect()->to('/');
    //     }
    // }

    //crea una funcion que me devuleva el numero de 
    public function editarInscripcion($id)
    {
        if (Auth::check()) {
            $inscripcion = Inscripcione::find($id);

            if (!$inscripcion) {
                return response()->json(['error' => 'Inscripción no encontrada'], 404);
            }

            $proyecto = Proyecto::select('clave_proyecto', 'nombre')->where('clave_proyecto', $inscripcion->clave_proyecto)->first();

            if (!$proyecto) {
                $proyecto = null;
            }
            $selectclaveproyecto = Proyecto::where('estado', true)->orderBy('clave_proyecto', 'asc')->pluck('clave_proyecto', 'id');

            return response()->json([
                'inscripcion' => $inscripcion,
                'proyecto' => $proyecto,
                'selectclaveproyecto' => $selectclaveproyecto
            ]);
        } else {
            return redirect()->to('/');
        }
    }


    // public function pdf($id)
    // {

    //     if (Auth::check()) {
    //         $inscripcion = Inscripcione::findOrFail($id);

    //         $pdf = PDF::loadView('incripciones.pdf', compact('inscripcion'));
    //         return $pdf->download('inscripcion.pdf');
    //     } else {
    //         return redirect()->to('/');
    //     }
    // }

    public function actualizarInscripcion($id, Request $request)
    {


        if (Auth::check()) {
            // dd($request->all());
            
            try {
                DB::beginTransaction();
                // dd($request->all());
                $inscripcion =  Inscripcione::find($id);
                $inscripcion->nombre_completo = strtoupper($request->input('nombre'));
                $inscripcion->direccion = $request->input('direccion');

                $inscripcion->clave_proyecto = $request->input('claveProyecto');
                $inscripcion->comite = $request->input('comite');
                $inscripcion->alcaldia = $request->input('alcaldia');
                $inscripcion->telefono = $request->input('telefono');
                $inscripcion->concepto = $request->input('concepto');
                $inscripcion->importe = $request->input('importeInscripcion');
                $inscripcion->numero_solicitud = $request->input('noSolicitud');
                $inscripcion->fecha_deposito = $request->input('fechaDeposito');
                // $inscripcion->fecha_registro = \Carbon\Carbon::now();

                // $inscripcion->hora_registro = date("H:i:s");
                $inscripcion->observaciones = $request->input('observaciones');
                $inscripcion->estado = 1;
                // dd($inscripcion);
                $inscripcion->save();

                DB::commit();

                return response()->json([
                    'mensaje' => 'Inscripción actualizada con éxito',
                    'idnotificacion' => 1
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'mensaje' => 'Error al actualizar',
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function eliminarInscripcion($id)
    {
        if (Auth::check()) {

            DB::beginTransaction();
            try {
                $inscripcion = Inscripcione::find($id);

                $inscripcion->estado = 0;
                $inscripcion->save();
                DB::commit();
                return response()->json([
                    'mensaje' => 'Eliminado éxito',
                    'idnotificacion' => 1
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'mensaje' => 'Error al eliminar' . $e->getMessage(),
                    'idnotificacion' => 2
                ]);
            }
        } else {
            return redirect()->to('/');
        }
    }
}
