<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineaTiempo;
use App\Models\Tema;

class LineaTiempoController extends Controller
{
    function CrearLineaTiempo(Request $request){
        $NombreLinea = LineaTiempo::select('Nombre')
            ->where('CodigoTema', $request->CodigoTema)
            ->where('Nombre', $request->Nombre)->first();

        if(!$NombreLinea){
            if(Tema::find($request->CodigoTema)){
                LineaTiempo::Create([
                    'Nombre' => $request->Nombre,
                    'PalabrasClave' => $request->PalabrasClave,
                    'Descripcion' => $request->Descripcion,
                    'Estado' => $request->Estado,
                    'Vista' => $request->Vista,
                    'CodigoTema' => $request->CodigoTema,
                ]);

                return response() -> json([
                    'ok' => true,
                    'message' => 'Línea de Tiempo creada correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El código de Tema no existe',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El nombre de la línea de tiempo ya existe',
            ]);
        }
    }

    function ActualizarLineaTiempo($Codigo, Request $request){
        $LineaTiempo = LineaTiempo::find($Codigo);

        if($LineaTiempo){
            if($LineaTiempo->Estado!=2){ //Estado = 2, es 'Dado de Baja'
                if($request->Nombre){
                    $NombreLinea = LineaTiempo::select('Nombre')
                        ->where('CodigoTema', $LineaTiempo->CodigoTema)
                        ->where('Nombre', $request->Nombre)->first();
                    
                        if(!$NombreLinea){
                            $LineaTiempo->Nombre = $request->Nombre;
                        } else{
                            return response() -> json([
                                'ok' => false,
                                'message' => 'El nombre de la Línea de Tiempo ya existe',
                            ]);
                        }
                }
                $request->PalabrasClave ? $LineaTiempo->PalabrasClave = $request->PalabrasClave : null;
                $request->Descripcion ? $LineaTiempo->Descripcion = $request->Descripcion : null;
    
                $LineaTiempo->save();
    
                return response() -> json([
                    'ok' => true,
                    'message' => 'Línea de Tiempo actualizada correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'La Línea de Tiempo, está dada de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de la Línea de Tiempo, no existe',
            ]);
        }
    }

    function ModificarEstado($Codigo, Request $request){
        $LineaTiempo = LineaTiempo::find($Codigo);

        if($LineaTiempo){
            if($LineaTiempo->Estado != $request->Estado){
                $LineaTiempo->Estado = $request->Estado;

                $LineaTiempo->save();

                return response() -> json([
                    'ok' => true,
                    'message' => 'Estado actualizado',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'No puede modificarse al mismo estado',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de la Línea de Tiempo, no existe',
            ]);
        }
    }

    function ModificarVista($Codigo, Request $request){
        $LineaTiempo = LineaTiempo::find($Codigo);

        if($LineaTiempo){
            if($LineaTiempo->Vista != $request->Vista){
                $LineaTiempo->Vista = $request->Vista;

                $LineaTiempo->save();

                return response() -> json([
                    'ok' => true,
                    'message' => 'Vista actualizada',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'No puede modificarse a la misma vista',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de la Línea de Tiempo, no existe',
            ]);
        }
    }

    function ListarLineasTema($CodigoTema){
        $Lineas = LineaTiempo::where('CodigoTema', $CodigoTema)->get();

        return response() -> json($Lineas);
    }

    function BuscarLineas($Palabra){
        return LineaTiempo::where('PalabrasClave', 'LIKE', "%$Palabra%")
            ->orWhere('Nombre', 'LIKE', "%$Palabra%")->get();
    }
}
