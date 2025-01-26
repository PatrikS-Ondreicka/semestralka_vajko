<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Data;

class DataApiController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        // TODO: Implement index() method.
    }

    public function getOne(): Response
    {
        $req = $this->request();
        $id = $req->getValue('id');
        $result = Data::getOne($id);
        return $this->json($result);
    }

    public function getAllData(): Response
    {
        $result = Data::getAll();
        return $this->json($result);
    }

    public function getUserData(): Response
    {
        $req = $this->request();
        $user_id = $req->getValue('userId');
        $result = Data::getAll('user = ?', [$user_id]);
        return $this->json($result);
    }

    public function getPrecipitation()
    {
        $req = $this->request();
        $data = Data::getAll();
        $result = $this->getDataAttribute("precipitation", $data);
        return $this->json($result);
    }

    public function getTemperature()
    {
        $req = $this->request();
        $data = Data::getAll();
        $result = $this->getDataAttribute("temperature", $data);
        return $this->json($result);
    }

    public function getHumidity()
    {
        $req = $this->request();
        $data = Data::getAll();
        $result = $this->getDataAttribute("humidity", $data);
        return $this->json($result);
    }

    public function getWindSpeed()
    {
        $req = $this->request();
        $data = Data::getAll();
        $result = $this->getDataAttribute("wind_speed", $data);
        return $this->json($result);
    }

    private function getDataAttribute(string $name, $data) : array
    {
        $result = [];
        foreach ($data as $datum) {
            switch ($name) {
                case 'temperature':
                    $result[] = ["value" => $datum->getTemperature(), "date" => $datum->getDate()];
                    break;
                case 'humidity':
                    $result[] = ["value" => $datum->getHumidity(), "date" => $datum->getDate()];
                    break;
                case 'wind_speed':
                    $result[] = ["value" => $datum->getWindSpeed(), "date" => $datum->getDate()];
                    break;
                case 'precipitation':
                    $result[] = ["value" => $datum->getPrecipitation(), "date" => $datum->getDate()];
                    break;
                default:
                    break;
            }
        }
        return $result;
    }
}