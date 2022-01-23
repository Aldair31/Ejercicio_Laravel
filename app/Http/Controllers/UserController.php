<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    function register(Request $request){
        User :: Create([
            'id'=>$request->id,
            'name' => $request->name,
            'email'=> $request->email,
            'photo'=> $request->photo,
            // 'current'=> true
        ]);
        // print($request);
        // echo 'HOLA';
        info('HOLA MUNDO');
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("Hello from Terminal");
        return response() -> json([
            'message'=>'Successfully created user!'
        ], 201);
    }
}
