<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use MongoDB\Client as Mongo;

class controladorUsuarios extends Controller
{
    protected $collection;

    public function __construct()
    {
        $this->collection = (new Mongo)->{env('DB_DATABASE')}->usuarios;
    }

    public function register(Request $request)
{
    // Validar que el email y la contraseña están presentes en la solicitud
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'contrasena' => 'required|string|min:6',
    ]);

    // Comprobar si el usuario ya existe
    $existingUser = $this->collection->findOne(['email' => $request->email]);

    if ($existingUser) {
        return response()->json(['error' => 'El correo electrónico ya está registrado.'], 409);
    }

    // Crear nuevo usuario
    $user = [
        'nombre' => $request->nombre,
        'email' => $request->email,
        'contrasena' => bcrypt($request->contrasena),
        'favoritos' => [
            'actividades' => [],
            'restaurantes' => [],
            'itinerario' => []
        ],
        'historial' => [
            'actividades' => [],
            'restaurantes' => [],
            'itinerario' => []
        ]
    ];

    $this->collection->insertOne($user);

    return response()->json($user, 201);
}


public function login(Request $request)
{
    // Validar que el email y la contraseña están presentes en la solicitud
    $request->validate([
        'email' => 'required|string|email',
        'contrasena' => 'required|string',
    ]);

    $user = $this->collection->findOne(['email' => $request->email]);
    // imprimir lo que hay en $user
    //print_r($user);

    // Convertir el usuario a un array para poder acceder a las propiedades correctamente
    $userArray = json_decode(json_encode($user), true);


    if (isset($userArray['contrasena']) && password_verify($request->contrasena, $userArray['contrasena'])) {
        // Aquí puedes generar un token o manejar la sesión como prefieras
        return response()->json(['message' => 'Login successful'], 200);
    }

    

    return response()->json(['error' => 'Unauthorized'], 401);
}

    
}
