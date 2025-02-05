<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Location;
use App\Models\Data;
use App\Models\User;
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

    public function authorize($action): bool
    {
        session_start();
        $auth = $this->app->getAuth();
        $req = $this->request();
        switch ($action) {
            case "edit":
            case "delete":
                if (!$auth->isLogged()) {
                    return false;
                }
                $logged_id = $auth->getLoggedUserId();
                $logged_user = User::getOne($logged_id);
                return $logged_user->getRole() != 0;
            default:
                return true;
        }
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

    public function map() {
        return $this->html();
    }

    public function data() {
        $req = $this->request();
        $location_id = $req->getValue("location_id");
        $location = Location::getOne($location_id);
        if ($location == null) {
            return new RedirectResponse($this->url("location.error", ["message" => "Unable to find location"]));
        }
        $data = Data::getAll("`location` = ?", [$location_id]);
        return $this->html(["weather_date" => $data, 'location' => $location]);
    }

    public function error()
    {
        $req = $this->request();
        $message = $req->getValue('message');
        return $this->html(["message" => $message]);
    }
}