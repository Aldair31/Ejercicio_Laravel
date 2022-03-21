<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Pais;

class PersonaController extends Controller
{
    function CrearPersona(Request $request){
        $correo = Persona::select('Correo')->where('Correo', $request->Correo)->first();
        if(!$correo){
            Persona::Create([
                'Correo' => $request->Correo,
                'Foto' => $request->Foto,
                'Vigencia' => $request->Vigencia,
            ]);
    
            return response() -> json([
                'ok'=> true,
                'message' => 'La persona ha sido creado correctamente',
            ], 201);
        } else {
            return response() -> json([
                'ok'=> false,
                'message' => 'Persona Logeado',
            ], 201);
        }
    }

    function ActualizarPersona($Codigo, Request $request){
        $Persona = Persona::find($Codigo); 

        if($Persona){
            if($Persona->Vigencia==1){
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
            if($Persona->Vigencia==1){
                $Persona->Vigencia = 2;

                $Persona->save();

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
            if($Persona->Vigencia==1){
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
