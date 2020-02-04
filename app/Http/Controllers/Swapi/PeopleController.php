<?php

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use App\Http\Models\Person;
use App\Http\Services\Swapi\PeopleService;
use Illuminate\Http\Response;
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

    /**
     * @return Response
     */
    public function fetchPeopleAction(): Response
    {
        DB::table('swapi_people')->delete();

        $people = $this->peopleService->fetchPeople();
        DB::table('swapi_people')->insert($people);

        return response(__('swapi.people_saved'), 200);
    }

    public function getPersonAction(string $name)
    {

    }
}
