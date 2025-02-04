<?php

namespace App\Controllers;

use App\Controllers\LocationController;
use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Core\Request;
use App\Models\Location;
use App\Models\Profile;
use App\Models\ReportType;
use \DateTime;
use App\Models\Data;
use function Sodium\add;

class DataController extends AControllerBase
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
            case "dataform":
                return $auth->isLogged();
            case "dataedit":
            case "uploadData":
            case "deleteData":
                if (!$auth->isLogged()) {
                    return false;
                }
                $data_id = $req->getValue('dataId');
                $data = Data::getOne($data_id);
                if ($data != null && $data->getUser() != null) {
                $logged_id = $auth->getLoggedUserId();
                    return $data->getUser() == $logged_id;
                }
                return true;
            default:
                return true;
        }
    }


    public function data() : Response
    {
        return $this->html();
    }

    public function dataform() : Response
    {
        $req = $this->request();
        $weather_data = $req->getValue('weatherData');
        $errors = $req->getValue('errors');
        return $this->html(['weatherData' => $weather_data, 'errors' => $errors]);
    }

    public function statistics() : Response
    {
        return $this->html();
    }

    public function detail() : Response
    {
        $req = $this->request();
        $id = $req->getValue('dataId');
        $data = Data::getOne($id);
        $profiles = Profile::getAll("`user` = ?", [$data->getUser()]);
        $profile = count($profiles) > 0 ? $profiles[0] : null;
        if ($data == null)
        {
            return new RedirectResponse($this->url("data.error", ['message' => "Unable to fetch data with id ".$id]));
        }
        $location = Location::getOne($data->getLocation());
        $report_types = ReportType::getAll();
        return $this->html(['weather_data' => $data, 'location' => $location, 'report_types' => $report_types, 'profile' => $profile]);
    }

    public function uploadData() : Response
    {
        $req = $this->request();
        $id = $req->getValue('dataId');
        $errors = array();
        $data = null;
        if ($id > 0)
        {
            $data = Data::getOne($id);
        } else {
            $data = new Data();
        }
        session_start();
        $data->setTemperature($req->getValue('temperature'));
        $data->setHumidity($req->getValue('humidity'));
        $data->setWindSpeed($req->getValue('wind_speed'));
        $data->setWindDirection($req->getValue('wind_direction'));
        $data->setPrecipitation($req->getValue('precipitation'));
        $data->setUser($this->app->getAuth()->getLoggedUserId());
        $data->setDate((new DateTime())->format('Y-m-d H:i:s'));

        if (is_null($data->getTemperature()) || $data->getTemperature() < Data::MIM_TEMP
            || $data->getTemperature() > Data::MAX_TEMP) {
            $errors[] = "Value of temperature must be between -90.0 and 57.0";
        }

        if (is_null($data->getHumidity()) || $data->getHumidity() < Data::MIN_HUM
            || $data->getHumidity() > Data::MAX_HUM) {
            $errors[] = "Value of humidity must be between 0 and 100";
        }

        if (is_null($data->getWindSpeed()) || $data->getWindSpeed() < Data::MIN_WIND_SPEED) {
            $errors[] = "Value of wind speed must be greater or equal to 0";
        }

        if (is_null($data->getWindDirection() || !in_array($data->getWindDirection(),
                DATA::WIND_DIRECTION_VALUES))) {
            $errors[] = "Unsupported wind direction value";
        }

        if (is_null($data->getPrecipitation()) || $data->getPrecipitation() < Data::MIN_PRECIP) {
            $errors[] = "Value of precipitation must be greater or equal to 0";
        }

        $selection_mode = $req->getValue("selection_mode");
        if ($selection_mode != "manual" && $selection_mode != "map") {
            $errors[] = "Selection mode is incorrect";
        }

        $lat = $req->getValue('lat');
        $lon = $req->getValue('lon');
        $lat = floatval(sprintf("%.4f", $lat));
        $lon = floatval(sprintf("%.4f", $lon));
        $loc_name = $req->getValue('loc_name');

        if ($lat == null || $lon == null) {
            $errors[] = "Location coordinates missing";
        }

        if (count(Location::getAll("`name` = ? AND (TRIM(lon) != ? || TRIM(lat) != ?)", [$loc_name, $lon, $lat])) > 0) {
            $errors[] = "Location name already exists";
        }

        $locations = Location::getAll("`name` = ? AND (TRIM(lon) = ? AND TRIM(lat) = ?)",  [$loc_name, $lon, $lat]);
        $location = null;
        if (count($locations) > 0) {
            $location = $locations[0];
        } else {
            $location = new Location();
            $location->setName(trim($loc_name));
            $location->setLat($lat);
            $location->setLon($lon);
            $location->save();
        }

        $data->setLocation($location->getId());
        if (!$errors) {
            $data->save();
            return new RedirectResponse($this->url("data.data"));
        } else {
            return new RedirectResponse($this->url("data.dataform", ['weatherData' => $data, 'errors' => $errors]));
        }
    }

    public function dataedit()
    {
        $req = $this->request();
        $id = (int) $req->getValue('dataId');

        $weatherData = Data::getOne($id);
        return $this->html(['weatherData' => $weatherData]);
    }


    public function deleteData() : Response
    {
        $req = $this->request();
        $data_id = $req->getValue('dataId');
        $data = Data::getOne($data_id);
        if (!is_null($data))
        {
            $data->delete();
            return new RedirectResponse($this->url("data.data"));
        }
        else {
            return new RedirectResponse($this->url("data.error", ['message' => "Unable to delete data with id ".$data_id]));
        }

    }

    public function error()
    {
        $req = $this->request();
        $message = $req->getValue('message');
        return $this->html(["message" => $message]);
    }
}