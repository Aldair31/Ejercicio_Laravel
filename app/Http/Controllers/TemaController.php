<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\Usuario;
use App\Models\LineaTiempo;

class TemaController extends Controller
{
    function CrearTema(Request $request){
        $NombreTema = Tema::select('Nombre')
            ->where('CodigoUsuario', $request->CodigoUsuario)
            ->where('Nombre', $request->Nombre)->first();

        if(!$NombreTema){
            if(Usuario::find($request->CodigoUsuario)){
                $Tema = Tema::Create([
                    'Nombre' => $request->Nombre,
                    'PalabrasClave' => $request->PalabrasClave,
                    'Descripcion' => $request->Descripcion,
                    'Vigencia' => $request->Vigencia,
                    'CodigoUsuario' => $request->CodigoUsuario,
                ]);

                return response() -> json([
                    'ok' => true,
                    'message' => 'Tema creado correctamente',
                    'Codigo' => $Tema->Codigo
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El código de Usuario no existe',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El nombre del tema ya existe',
            ]);
        }
    }

    function ActualizarTema($Codigo, Request $request){
        $Tema = Tema::find($Codigo);

        if($Tema){
            if($Tema->Vigencia=='A'){
                if($request->Nombre){
                    $NombreTema = Tema::select('Nombre')
                        ->where('CodigoUsuario', $Tema->CodigoUsuario)
                        ->where('Nombre', $request->Nombre)->first();
                    
                        if(!$NombreTema){
                            $Tema->Nombre = $request->Nombre;
                        } else{
                            return response() -> json([
                                'ok' => false,
                                'message' => 'El nombre del tema ya existe',
                            ]);
                        }
                }
                $request->PalabrasClave ? $Tema->PalabrasClave = $request->PalabrasClave : null;
                $request->Descripcion ? $Tema->Descripcion = $request->Descripcion : null;
    
                $Tema->save();
    
                return response() -> json([
                    'ok' => true,
                    'message' => 'Tema actualizado correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'No se puede actualizar, debido a que el Tema está dado de baja'
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código del Tema, no existe',
            ]);
        }
    }

    function DarDeBaja($Codigo){
        $Tema = Tema::find($Codigo);

        if($Tema){
            if($Tema->Vigencia == 'A'){
                $Tema->Vigencia = 'B';

                $Tema->save();

                LineaTiempo::where('CodigoTema', $Tema->Codigo)
                    ->update(['Estado' => 'B']);

                return response() -> json([
                    'ok' => true,
                    'message' => 'Tema dado de baja',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El Tema ya está dado de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código del Tema, no existe',
            ]);
        }
    }

    function ListarTemasUsuario($CodigoUsuario){
        $Temas = Tema::where('CodigoUsuario', $CodigoUsuario)
            ->where('Vigencia', 'A')
            ->get();

        return response() -> json($Temas);
    }

    function BuscarTema($Codigo){
        $Tema = Tema::find($Codigo);

        if($Tema){
            if($Tema->Vigencia=='A'){
                return response() -> json($Tema);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El Tema está dado de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Tema, no existe',
            ]);
        }
    }
}
