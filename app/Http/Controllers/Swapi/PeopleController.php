<?php

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use App\Http\Models\Person;
use App\Http\Services\Swapi\PeopleService;
use GuzzleHttp\Exception\RequestException;
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

        try {
            $this->peopleService->savePeople();
        } catch (RequestException $exception) {
            return response(__('swapi.swapi_api_error'), 503);
        }

        return response(__('swapi.people_saved'), 200);
    }

    /**
     * @return Response
     */
    public function getPeopleAction(): Response
    {
        $people = Person::all();

        return response($people, 200);
    }

    /**
     * @param string $name
     * @return Response
     */
    public function getPersonAction(string $name)
    {
        $name = str_replace('_', ' ', $name);
        $person = Person::query()
            ->where('name', 'like', '%' . $name . '%')
            ->first();

        if (is_null($person)) {
            return response(__('swapi.not_found'), 404);
        }

        return response($person, 200);
    }
}
