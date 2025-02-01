<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Location;
use App\Models\Data;
use Exception;
use PDO;

class LocationController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function delete(): Response
    {
        $req = $this->request();
        $location_id = $req->getValue("location_id");
        $uses = count(Data::getAll("`location` = ?", [$location_id]));
        if ($uses <= 0) {
            $location = Location::getOne($location_id);
            $location->delete();
        }

        return $this->redirect($this->url("adm.adminLocations"));
    }

    public function edit()
    {
        $req = $this->request();
        $location_id = $req->getValue("location_id");
        $location = Location::getOne($location_id);
        if (!is_null($req->getValue("submit"))) {
            $lat = $req->getValue("lat");
            $lon = $req->getValue("lon");
            $name = $req->getValue("name");
            $location->setLat($lat);
            $location->setLon($lon);
            $location->setName($name);
            $location->save();
        }

        return $this->html(["location" => $location]);
    }

    public static function locationExists(Location $location): bool
    {
        try {
            $con = Connection::connect();
            $stmt = $con->prepare("SELECT 'X' AS LOCATION_EXISTS FROM locations WHERE lat = ".$location->getLat()." AND lon = ".$location->getLon());
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !is_null($result['LOCATION_EXISTS']);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public static function selectLocation(Location $location): ?Location
    {
        try {
            $con = Connection::connect();
            $stmt = $con->prepare("SELECT id AS LOC_ID FROM locations WHERE lat LIKE ".$location->getLat()." AND lon LIKE ".$location->getLon());
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return Location::getOne($result['LOC_ID']);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}