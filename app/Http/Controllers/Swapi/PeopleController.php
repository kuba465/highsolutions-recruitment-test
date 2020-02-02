<?php

namespace App\Http\Controllers\Swapi;

use App\Http\Controllers\Controller;
use App\Http\Services\Swapi\PeopleService;

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
        dd($people);
    }

    public function getPersonAction(string $name)
    {

    }
}
