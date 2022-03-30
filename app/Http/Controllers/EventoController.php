<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\LineaTiempo;

class EventoController extends Controller
{
    function CrearEvento(Request $request){
        if(LineaTiempo::find($request->CodigoLineaTiempo)){
            $Evento = Evento::Create([
                'Titulo' => $request->Titulo,
                'Descripcion' => $request->Descripcion,
                'Fecha' => $request->Fecha,
                'Imagen' => $request->Imagen,
                'URL' => $request->URL,
                'Vigencia' => $request->Vigencia,
                'CodigoLineaTiempo' => $request->CodigoLineaTiempo
            ]);
    
            return response()->json([
                'ok' => true,
                'message' => 'Evento creado correctamente',
                'Codigo' => $Evento->Codigo
            ]);
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Línea de Tiempo no existe',
            ]);
        }
    }

    function ActualizarEvento($Codigo, Request $request){
        $Evento = Evento::find($Codigo);

        if($Evento){
            if($Evento->Vigencia=='A'){
                $request->Titulo ? $Evento->Titulo = $request->Titulo : null;
                $request->Descripcion ? $Evento->Descripcion = $request->Descripcion : null;
                $request->Fecha ? $Evento->Fecha = $request->Fecha : null;
                $request->Imagen ? $Evento->Imagen = $request->Imagen : null;
                $request->URL ? $Evento->URL = $request->URL : null;
                
                $Evento->save();

                return response() -> json([
                    'ok' => true,
                    'message' => 'Datos actualizados correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'Evento no existe con dicho Código'
                ]);
            }
        }
    }

    function DarDeBaja($Codigo){
        $Evento = Evento::find($Codigo);

        if($Evento){
            if($Evento->Vigencia == 'A'){
                $Evento->Vigencia = 'B';

                return response()->json([
                    'ok' => true,
                    'message' => 'Evento dado de baja'
                ]);
            } else{
                return response()->json([
                    'ok' => false,
                    'message' => 'Este evento ya se encuentra dado de baja'
                ]);
            }
        } else{
            return response()->json([
                'ok' => false,
                'message' => 'El código de Evento no existe'
            ]);
        }
    }

    function ListarEventos(){
        return Evento::all();
    }

    function ListarEventosLinea($CodigoLineaTiempo){
        // $LineaTiempo = LineaTiempo::find($CodigoLineaTiempo);
        $Eventos = Evento::where('CodigoLineaTiempo', $CodigoLineaTiempo)
            ->where('Vigencia', 'A')
            ->get();

        if($Eventos){
            return response()->json($Eventos);
        } else{
            return response()->json([
                'ok' => false,
                'message' => 'No existen eventos para dicha Línea de Tiempo'
            ]);
        }
    }
}
