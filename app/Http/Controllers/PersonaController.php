<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Pais;
use App\Models\Usuario;
use Illuminate\Http\Response;

class PersonaController extends Controller
{
    function CrearPersona(Request $request){
        $PersonaCreada = Persona::where('Correo', $request->Correo)->first();
        if(!$PersonaCreada){
            $Persona = Persona::Create([
                'Nombre' => $request->Nombre,
                'Apellidos' => $request->Apellidos,
                'Correo' => $request->Correo,
                'Foto' => $request->Foto,
                'Vigencia' => $request->Vigencia,
            ]);

            // $PersonaCreada = Persona::where('Correo', $request->Correo)->first();
            // $Persona->save();

            return response() -> json([
                'ok'=> true,
                'message' => 'La persona ha sido creado correctamente',
                'codigo' => $Persona->Codigo
            ], 201);
        } else {
            return response() -> json([
                'ok'=> false,
                'message' => 'Persona Logeado',
                'codigo' => $PersonaCreada->Codigo
            ], 201);
        }
    }

    function ActualizarPersona($Codigo, Request $request){
        $Persona = Persona::find($Codigo); 

        if($Persona){
            if($Persona->Vigencia=='A'){
                $request->Nombre ? $Persona->Nombre = $request->Nombre : null;
                $request->Apellidos ? $Persona->Apellidos = $request->Apellidos : null;
                $request->FechaNacimiento ? $Persona->FechaNacimiento = $request->FechaNacimiento : null;
                $request->Sexo ? $Persona->Sexo = $request->Sexo : null;
                if($request->CodigoPais){
                    if(Pais::find($request->CodigoPais)){
                        $Persona->CodigoPais = $request->CodigoPais;
                    } else{
                        return response() -> json([
                            'ok' => false,
                            'message' => 'El código de País, no existe'
                        ]);
                    }
                }
    
                $Persona->save();
    
                return response() -> json([
                    'ok' => true,
                    'message' => 'Datos actualizados correctamente',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'No se puede actualizar, debido a que la Persona está dada de baja'
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'Persona no existe con dicho Código'
            ]);
        }
    }

    function DarDeBaja($Codigo){
        $Persona = Persona::find($Codigo);
        
        if($Persona){
            if($Persona->Vigencia=='A'){
                $Persona->Vigencia = 'B';

                $Persona->save();

                Usuario::where('CodigoPersona', $Persona->Codigo)
                    ->update(['Vigencia' => 'B']);

                return response() -> json([
                    'ok' => true,
                    'message' => 'Persona dada de baja',
                ]);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'La persona ya está dado de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Persona, no existe'
            ]);
        }
    }

    function ListarPersonas(){
        return Persona::all();
    }

    function BuscarPersona($Codigo){
        $Persona = Persona::find($Codigo);

        if($Persona){
            if($Persona->Vigencia=='A'){
                return response() -> json($Persona);
            } else{
                return response() -> json([
                    'ok' => false,
                    'message' => 'La Persona está dado de baja',
                ]);
            }
        } else{
            return response() -> json([
                'ok' => false,
                'message' => 'El código de Persona, no existe',
            ]);
        }
    }
}
