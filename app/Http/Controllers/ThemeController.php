<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    //
    function create (Request $request) {
        Theme::create([
            'name'=>$request->name,
            'keywords'=>$request->keywords,
            'description'=>$request->description,
            'current'=>true,
            'codigo'=>$request->codigo,
        ]);
        return response()->json([
            'message'=>'Successfuly created themes!'
        ],201);
    }
}
