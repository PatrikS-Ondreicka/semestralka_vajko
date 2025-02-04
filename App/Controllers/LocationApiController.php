<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Location;

class LocationApiController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function getAllLocations(): Response
    {
        $locations = Location::getAll();
        return $this->json($locations);
    }

    public function getLocation(): Response
    {
        $req = $this->request();
        $loc_name = $req->getValue('locName');
        $locations = Location::getAll("`name` = ?" ,[$loc_name]);
        return $this->json($locations);
    }
}