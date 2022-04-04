<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;

use App\Http\Controllers\PaisController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\LineaTiempoController;
use App\Http\Controllers\EventoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[UserController::class, 'register']);
//Themes 
Route::post('createTheme',[ThemeController::class,'createTheme']);
Route::get('listTheme',[ThemeController::class,'listTheme']);
Route::get('searchTheme/{name?}',[ThemeController::class,'searchTheme']);
Route::put('editTheme/{id?}',[ThemeController::class,'editTheme']);
Route::delete('deleteTheme/{id?}', [ThemeController::class,'deleteTheme']);

//RUTAS DE PAIS
Route::controller(PaisController::class)->group(function(){
    Route::get('/Pais/ListarNombrePaises', 'ListarNombrePaises');
});

//RUTAS DE PERSONA
Route::controller(PersonaController::class)->group(function(){
    Route::post('/Persona/CrearPersona', 'CrearPersona');
    Route::put('/Persona/ActualizarPersona/{Codigo}', 'ActualizarPersona');
    Route::put('/Persona/DarDeBaja/{Codigo}', 'DarDeBaja');
    Route::get('/Persona/ListarPersonas', 'ListarPersonas');
    Route::get('/Persona/BuscarPersona/{Codigo}', 'BuscarPersona');
});

//RUTAS DE USUARIO
Route::controller(UsuarioController::class)->group(function(){
    Route::post('/Usuario/CrearUsuario', 'CrearUsuario');
    Route::put('/Usuario/ActualizarUsuario/{Codigo}', 'ActualizarUsuario');
    Route::put('/Usuario/DarDeBaja/{Codigo}', 'DarDeBaja');
    Route::get('/Usuario/ListarUsuarios', 'ListarUsuarios');
    Route::get('/Usuario/BuscarUsuario/{Codigo}', 'BuscarUsuario'); //BuscarUsuarioCodigoPersona
    Route::get('/Usuario/BuscarUsuarioCodigoPersona/{CodigoPersona}', 'BuscarUsuarioCodigoPersona');
});

//RUTAS DE TEMA
Route::controller(TemaController::class)->group(function(){
    Route::post('/Tema/CrearTema', 'CrearTema');
    Route::put('/Tema/ActualizarTema/{Codigo}', 'ActualizarTema');
    Route::put('/Tema/DarDeBaja/{Codigo}', 'DarDeBaja');
    Route::get('/Tema/ListarTemasUsuario/{CodigoUsuario}', 'ListarTemasUsuario');
    Route::get('/Tema/BuscarTema/{Codigo}', 'BuscarTema');
});

//RUTAS DE LINEA DE TIEMPO
Route::controller(LineaTiempoController::class)->group(function(){
    Route::post('/LineaTiempo/CrearLineaTiempo', 'CrearLineaTiempo');
    Route::put('/LineaTiempo/ActualizarLineaTiempo/{Codigo}', 'ActualizarLineaTiempo');
    Route::put('/LineaTiempo/ModificarEstado/{Codigo}', 'ModificarEstado');
    Route::put('/LineaTiempo/ModificarVista/{Codigo}', 'ModificarVista');
    Route::get('/LineaTiempo/ListarLineasTema/{CodigoTema}', 'ListarLineasTema');
    Route::get('/LineaTiempo/BuscarLineas/{Palabra}', 'BuscarLineas');
    // Route::get('/LineaTiempo/BuscarTema/{Codigo}', 'BuscarTema');
});

//RUTAS DE EVENTO
Route::controller(EventoController::class)->group(function(){
    Route::post('/Evento/CrearEvento', 'CrearEvento');
    Route::put('/Evento/ActualizarEvento/{Codigo}', 'ActualizarEvento');
    Route::put('/Evento/DarDeBaja/{Codigo}', 'DarDeBaja');
    Route::get('/Evento/ListarEventos', 'ListarEventos');
    Route::get('/Evento/ListarEventosLinea/{CodigoLinea}', 'ListarEventosLinea');
});