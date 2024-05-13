<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class controladorFlask extends Controller
{
    public function hacerPeticionFlask($prompt)
    {
        // URL de tu servidor Flask
        $url = "http://localhost:5000/primes/" . urlencode($prompt);

        // Realizar la solicitud a Flask
        $respuesta = file_get_contents($url);

        // Decodificar la respuesta JSON
        $respuesta_decodificada = json_decode($respuesta, true);

        // Devolver la respuesta
        return response()->json($respuesta_decodificada);
    }
}
