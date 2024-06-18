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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contrasena' => 'required|string|min:6',
        ]);

        $existingUser = $this->collection->findOne(['email' => $request->email]);

        if ($existingUser) {
            return response()->json(['error' => 'El correo electrónico ya está registrado.'], 409);
        }

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
        $request->validate([
            'email' => 'required|string|email',
            'contrasena' => 'required|string',
        ]);

        $user = $this->collection->findOne(['email' => $request->email]);

        $userArray = json_decode(json_encode($user), true);

        if (isset($userArray['contrasena']) && password_verify($request->contrasena, $userArray['contrasena'])) {
            return response()->json(['message' => 'Login successful', 'user' => $userArray], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getFavoritos(Request $request)
    {
        $user = $this->collection->findOne(['email' => $request->email]);

        if ($user) {
            return response()->json($user['favoritos'], 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function addFavorito(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'lugar' => 'required|string',
            'tipo' => 'required|string',
        ]);

        $user = $this->collection->findOne(['email' => $request->email]);

        if ($user) {
            $favoritoTipo = 'favoritos.' . $request->tipo;
            $this->collection->updateOne(
                ['email' => $request->email],
                ['$push' => [$favoritoTipo => ['lugar' => $request->lugar]]]
            );

            return response()->json(['message' => 'Favorito added successfully'], 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
