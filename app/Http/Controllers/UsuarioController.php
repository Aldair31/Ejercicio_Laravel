<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Persona;

class UsuarioController extends Controller
{
    function CrearUsuario(Request $request){
        $NombreUsuario = Usuario::select('NombreUsuario')->where('NombreUsuario', $request->NombreUsuario)->first();

        if(!$NombreUsuario){
            if(Persona::find($request->CodigoPersona)){
                Usuario::Create([
                    'NombreUsuario' => $request->NombreUsuario,
                    'Vigencia' => $request->Vigencia,
                    'CodigoPersona' => $request->CodigoPersona,
                ]);
    
                return response() -> json([
                    'ok' => true,
                    'message' => 'Usuario creado correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El código de Persona, no existe'
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El nombre de usuario ya existe',
                'NombreUsuario' => $NombreUsuario
            ]);
        }
    }

    function ActualizarUsuario($Codigo, Request $request){
        $Usuario = Usuario::find($Codigo);

        if($Usuario){
            if($Usuario->Vigencia==1){
                $NombreUsuario = Usuario::select('NombreUsuario')->where('NombreUsuario', $request->NombreUsuario)->first();
                if(!$NombreUsuario){
                    $Usuario->NombreUsuario = $request->NombreUsuario;

                    $Usuario->save();

                    return response() -> json([
                        'ok' => true,
                        'message' => 'Usuario actualizado',
                    ]);
                } else{
                    return response() -> json([
                        'ok' => false,
                        'message' => 'El nombre de usuario ya existe',
                    ]);
                }
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El usuario está dado de baja',
                ]);
            }
        } else {
            return response() -> json([
                'ok' => false,
                'message' => 'El código de usuario, no existe'
            ]);
        }
    }

    function DarDeBaja($Codigo){
        $Usuario = Usuario::find($Codigo);

        if($Usuario){
            if($Usuario->Vigencia==1){
                $Usuario->Vigencia = 2;

                $Usuario->save();

                return response() -> json([
                    'ok' => true,
                    'message' => 'Usuario dado de baja',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El usuario ya está dado de baja',
                ]); 
            }
        } else {
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Usuario, no existe'
            ]);
        }
    }

    function ListarUsuarios(){
        return Usuario::all();
    }

    function BuscarUsuario($Codigo){
        $Usuario = Usuario::find($Codigo);

        if($Usuario){
            if($Usuario->Vigencia==1){
                // return response() -> json([
                //     'ok' => true,
                //     'Usuario' => $Usuario,
                // ]);
                return response() -> json($Usuario);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El usuario está dado de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Usuario, no existe'
            ]);
        }
    }
}
