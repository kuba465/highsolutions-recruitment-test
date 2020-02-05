<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @package App\Http\Models
 * @property int $id
 * @property string $name
 * @property string $height
 * @property string $mass
 * @property string $hair_color
 * @property string $skin_color
 * @property string $eye_color
 * @property string $birth_year
 * @property string $gender
 * @property string $homeworld
 * @property array $films
 * @property array $species
 * @property array $vehicles
 * @property array $starships
 * @property Carbon $created
 * @property Carbon $edited
 * @property string $url
 */
class Person extends Model
{
    protected $table = 'swapi_people';

    public $timestamps = false;

    protected $casts = [
        'films' => 'array',
        'species' => 'array',
        'vehicles' => 'array',
        'starships' => 'array',
        'created' => 'datetime:Y-m-d H:i:s',
        'edited' => 'datetime:Y-m-d H:i:s'
    ];
}
