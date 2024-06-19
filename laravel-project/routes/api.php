<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controladorFlask;
use App\Http\Controllers\controladorActividades;
use App\Http\Controllers\controladorItinerarios;
use App\Http\Controllers\controladorRestaurantes;
use App\Http\Controllers\controladorUsuarios;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/hello', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::get('/prueba', [controladorFlask::class, 'prueba']); 
Route::get('/hacer-peticion-flask/{prompt}', [controladorFlask::class, 'hacerPeticionFlask']);
Route::post('/formularioactividades', [controladorActividades::class, 'formularioActividades']); 
Route::post('/formulariorestaurantes', [controladorRestaurantes::class, 'formularioRestaurantes']);
Route::post('/formularioitinerario', [controladorItinerarios::class, 'formularioItinerarios']);

Route::post('register', [controladorUsuarios::class, 'register']);
Route::post('login', [controladorUsuarios::class, 'login']);


Route::post('get-favoritos', [controladorUsuarios::class, 'getFavoritos']);
Route::post('add-favorito', [controladorUsuarios::class, 'addFavorito']);

Route::post('addFavoritoItinerario', [controladorUsuarios::class, 'addFavoritoItinerario']);

Route::post('get-historial', [controladorUsuarios::class, 'getHistorial']);
Route::post('add-historial', [controladorUsuarios::class, 'addHistorial']);

Route::post('addHistorialItinerario', [controladorUsuarios::class, 'addHistorialItinerario']);
