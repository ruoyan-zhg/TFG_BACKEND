<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;
use Exception;

class controladorRestaurantes extends Controller
{
    public function formularioRestaurantes(Request $request)
{
    
    // Crear un objeto stdClass para almacenar los datos del formulario
    $formulario = new stdClass();
    $formulario->ciudad = $request->ciudad;
    $formulario->zona = $request->zona;
    $formulario->ocasion = $request->ocasion;
    $formulario->ninos = $request->ninos;
    $formulario->preferencias = $request->preferencias;
    $formulario->evitar = $request->evitar;
    
    // devolver formulario 
    

    // Convertir el objeto en un array asociativo
    $data = (array) $formulario;

    // Inicializar cURL
    $ch = curl_init();

    // Configurar cURL
    curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/formularioRestaurantes");  // Asegúrate de reemplazar esto con tu URL de Flask
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud cURL
    $response = curl_exec($ch);

    // Verificar si ocurrió algún error durante la solicitud
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    // Cerrar el recurso cURL
    curl_close($ch);

    // Opcional: Manejar la respuesta de Flask
    echo $response;
}
}
