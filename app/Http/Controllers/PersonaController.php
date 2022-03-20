<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
    function CrearPersona(Request $request){
        $correo = Persona::select('Correo')->where('Correo', $request->Correo)->first();
        if(!$correo){
            Persona::Create([
                'Correo' => $request->Correo,
                'Foto' => $request->Foto,
                'Vigencia' => 1,
            ]);
    
            return response() -> json([
                'ok'=> true,
                'message' => 'El usuario ha sido creado correctamente',
            ], 201);
        } else {
            return response() -> json([
                'ok'=> false,
                'message' => 'F por tu patita',
            ], 201);
        }
    }
}
