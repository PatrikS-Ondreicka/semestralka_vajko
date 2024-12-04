<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Core\Request;
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


    public function data() : Response
    {
        return $this->html();
    }

    public function dataform() : Response
    {
        return $this->html();
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
        $data->setTemperature($req->getValue('temperature'));
        $data->setHumidity($req->getValue('humidity'));
        $data->setWindSpeed($req->getValue('wind_speed'));
        $data->setWindDirection($req->getValue('wind_direction'));
        $data->setPrecipitation($req->getValue('precipitation'));
        $data->setLocation(1); // will be replaced by location from database
        $data->setUser(1); // will be re replaced by id of the logged user
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
        $data = Data::getOne($req->getValue('dataId'));

        if (!is_null($data)) {
            $data->delete();
        }
        return new RedirectResponse($this->url("data.data"));
    }
}