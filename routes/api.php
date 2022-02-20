<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;
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