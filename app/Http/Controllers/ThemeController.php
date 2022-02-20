<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    //
    function createTheme (Request $request) {
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
    function listTheme(){
        return Theme::all();
    }
    function searchTheme($name=null){
        if($name){
            $themes = Theme::where('name','like',"%$name") -> get();
            return $themes;
        }
        else{
            return ['msg'=>'Por favor ingrese un nombre'];
        }
    }

    function editTheme($id=null, Request $request){
        if($id){
            $themes = Theme::find($id);
            if($themes){
                $themes->name = $request->name;
                $themes->keywords = $request->keywords;
                $themes->description = $request->description;
                $themes->current = $request->current;
                $themes->codigo = $request->codigo;

                $addThemes= $themes->save();
                if($addThemes){
                    return ['msj'=>'Tema editado exitosamente'];
                }
                else{
                    return ['msj'=> 'La operación de editar falló'];
                }
            }
            else{
                return ['msj'=>'No se encontró tema a editar'];
            }
        }
        else{
            return ['msj'=>'Por favor ingrese un id'];
        }
    }

    function deleteTheme($id=null){
        if($id){
            $themes = Theme::find($id);
            if($themes){
                $deleteThemes=$themes->delete();
                if($deleteThemes){
                    return ['msj'=>'Tema eliminado exitosamente'];
                }
                else{
                    return ['msj'=>'La operación de eliminar falló'];
                }
            }
            else{
                return ['msj'=>'No se encontró tema a elimnar'];
            }
        }
        else{
            return ['msj'=>'Por favor ingrese un id'];
        }
    }

}
