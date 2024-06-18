<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Client as Mongo;

class Usuario extends Model
{
    use HasFactory;

    protected $collection = 'usuarios';
    protected $connection = 'mongodb';

    protected $fillable = [
        'nombre',
        'email',
        'contrasena',
        'favoritos',
        'historial',
    ];

    // Aquí puedes agregar métodos específicos para interactuar con MongoDB si es necesario
}
