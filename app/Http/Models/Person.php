<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'swapi_people';

    protected $casts = [
        'films' => 'array',
        'species' => 'array',
        'vehicles' => 'array',
        'starships' => 'array',
//        'created' => 'datetime:Y-m-d H:i:s',
//        'edited' => 'datetime:Y-m-d H:i:s'
    ];
}
