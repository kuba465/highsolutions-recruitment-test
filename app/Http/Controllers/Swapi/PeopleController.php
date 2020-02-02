<?php

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use App\Http\Models\Person;
use App\Http\Services\Swapi\PeopleService;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
    /**
     * @var PeopleService
     */
    private $peopleService;

    /**
     * PeopleController constructor.
     * @param PeopleService $peopleService
     */
    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    public function getPeopleAction()
    {
        $people = $this->peopleService->fetchPeople();

        DB::table('swapi_people')->insert($people);
    }

    public function getPersonAction(string $name)
    {

    }
}
