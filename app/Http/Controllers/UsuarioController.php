<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Tema;

class UsuarioController extends Controller
{
    function CrearUsuario(Request $request){
        $NombreUsuario = Usuario::select('NombreUsuario')->where('NombreUsuario', $request->NombreUsuario)->first();

        if(!$NombreUsuario){
            if(Persona::find($request->CodigoPersona)){
                $Usuario = Usuario::Create([
                    'NombreUsuario' => $request->NombreUsuario,
                    'Vigencia' => $request->Vigencia,
                    'CodigoPersona' => $request->CodigoPersona,
                ]);
    
                return response() -> json([
                    'ok' => true,
                    'message' => 'Usuario creado correctamente',
                    'Codigo' => $Usuario->Codigo
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'El código de Persona, no existe',
                    'Codigo' => $NombreUsuario->Codigo
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El nombre de usuario ya existe',
            ]);
        }
    }

    function ActualizarUsuario($Codigo, Request $request){
        $Usuario = Usuario::find($Codigo);

        if($Usuario){
            if($Usuario->Vigencia=='A'){
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
            if($Usuario->Vigencia=='A'){
                $Usuario->Vigencia = 'B';

                $Usuario->save();

                Tema::where('CodigoUsuario', $Usuario->Codigo)
                    ->update(['Vigencia' => 'B']);

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
            if($Usuario->Vigencia=='A'){
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

    function BuscarUsuarioCodigoPersona($CodigoPersona){
        $Usuario = Usuario::where('CodigoPersona', $CodigoPersona)
            ->where('Vigencia', 'A')
            ->first();

        if($Usuario){
            return response() -> json($Usuario);
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'Usuario no existe con dicho código de Persona'
            ]);
        }
    }
}
