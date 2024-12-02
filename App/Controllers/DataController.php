<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Core\Request;
use \DateTime;
use App\Models\Data;

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
        $data = new Data();

        $data->setTemperature($req->getValue('temperature'));
        $data->setHumidity($req->getValue('humidity'));
        $data->setWindSpeed($req->getValue('wind_speed'));
        $data->setWindDirection($req->getValue('wind_direction'));
        $data->setPrecipitation($req->getValue('precipitation'));
        $data->setLocation(1); // will be replaced by location from database
        $data->setUser(1); // will be re replaced by id of the logged user
        $data->setDate((new DateTime())->format('Y-m-d H:i:s'));

        $data->save();
        return new RedirectResponse($this->url("data.data"));
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