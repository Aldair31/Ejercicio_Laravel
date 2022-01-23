<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    function register(Request $request){
        $user=User :: Create([
            'codigo'=> $request->codigo,
            'name' => $request->name,
            'email'=> $request->email,
            'photo'=> $request->photo,
            'current'=> true
        ]);
        info('HOLA MUNDO');
        $token = $user->createToken('my-app-token')->plainTextToken;
        return response() -> json([
            'message'=>'Successfully created user!',
            'token'=>$token
        ], 201);
    }
}
