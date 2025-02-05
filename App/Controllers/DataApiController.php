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
        $req = $this->request();
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = $req->getValue('location');
        $result = [];

        if ($minDate !== "undefined" && $maxDate !== "undefined") {
            $result = Data::getAll('date >= ? AND date <= ?', [$minDate, $maxDate]);
        } elseif ($minDate !== "undefined") {
            $result = Data::getAll('date >= ?', [$minDate]);
        } elseif ($maxDate !== "undefined") {
            $result = Data::getAll('date <= ?', [$maxDate]);
        } else {
            $result = Data::getAll();
        }

        if ($location !== "undefined") {
            $result = $this->locationFilter($location, $result);
        }

        return $this->json($result);
    }

    public function getUserData(): Response
    {
        $req = $this->request();
        $user_id = $req->getValue('userId');
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = $req->getValue('location');

        if ($minDate !== null && $maxDate !== null) {
            $result = Data::getAll('user = ? AND date >= ? AND date <= ?', [$user_id, $minDate, $maxDate]);
        } elseif ($minDate !== null) {
            $result = Data::getAll('user = ? AND date >= ?', [$user_id, $minDate]);
        } elseif ($maxDate !== null) {
            $result = Data::getAll('user = ? AND date <= ?', [$user_id, $maxDate]);
        } else {
            $result = Data::getAll('user = ?', [$user_id]);
        }

        if ($location !== "undefined") {
            $result = $this->locationFilter($location, $result);
        }

        return $this->json($result);
    }

    public function getPrecipitation()
    {
        $req = $this->request();
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = $req->getValue('location');
        $type = $req->getValue('type');
        $data = $this->getDateFilteredData($minDate, $maxDate);
        if ($location !== "undefined") {
            $data = $this->locationFilter($location, $data);
        }
        $result = $this->getDataAttribute("precipitation", $data);
        $result = $this->typeFilter($type, $result);
        return $this->json($result);
    }

    public function getTemperature()
    {
        $req = $this->request();
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = (int)$req->getValue('location');
        $type = $req->getValue('type');
        $data = $this->getDateFilteredData($minDate, $maxDate);
        if ($location !== 0) {
            $data = $this->locationFilter($location, $data);
        }
        $result = $this->getDataAttribute("temperature", $data);
        $result = $this->typeFilter($type, $result);
        return $this->json($result);
    }

    public function getHumidity()
    {
        $req = $this->request();
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = $req->getValue('location');
        $type = $req->getValue('type');
        $data = $this->getDateFilteredData($minDate, $maxDate);
        if ($location !== "undefined") {
            $data = $this->locationFilter($location, $data);
        }
        $result = $this->getDataAttribute("humidity", $data);
        $result = $this->typeFilter($type, $result);
        return $this->json($result);
    }

    public function getWindSpeed()
    {
        $req = $this->request();
        $minDate = $req->getValue('minDate');
        $maxDate = $req->getValue('maxDate');
        $location = $req->getValue('location');
        $type = $req->getValue('type');
        $data = $this->getDateFilteredData($minDate, $maxDate);
        if ($location !== "undefined") {
            $data = $this->locationFilter($location, $data);
        }
        $result = $this->getDataAttribute("wind_speed", $data);
        $result = $this->typeFilter($type, $result);
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
        usort($result, function($a, $b) {
            return $a["date"] <=> $b["date"];
        });
        return $result;
    }

    private function getDateFilteredData($minDate = "undefined", $maxDate = "undefined") {
        $data = [];

        if ($minDate !== "undefined" && $maxDate !== "undefined") {
            $data = Data::getAll('date >= ? AND date <= ?', [$minDate, $maxDate]);
        } elseif ($minDate !== "undefined") {
            $data = Data::getAll('date >= ?', [$minDate]);
        } elseif ($maxDate !== "undefined") {
            $data = Data::getAll('date <= ?', [$maxDate]);
        } else { //If both are "undefined"
            $data = Data::getAll();
        }

        return $data;
    }

    private function locationFilter($location, $data)
    {
        $result = [];
        foreach ($data as $datum) {
            if ($location == $datum->getLocation()) {
                $result[] = $datum;
            }
        }
        return $result;
    }

    private function typeFilter($type, $data_pairs)
    {
        $result = [];
            switch ($type) {
                case "min":
                    return $this->filterMin($data_pairs);
                case "max":
                    return $this->filterMax($data_pairs);
                default:
                    return $data_pairs;
            }
    }

    private function filterMin($data_pairs) {
        $current_date = null;
        $current_min = 100;
        $result = [];
        foreach ($data_pairs as $pair) {
            $date = $pair["date"];
            $value = $pair["value"];
            if (explode(" ", $date)[0] != $current_date) {
                if ($current_min == 100) {
                    $current_min = $pair["value"];
                }
                $result[] = ["value" => $current_min, "date" => $date];
                $current_date = explode(" ", $date)[0];
                $current_min = $pair["value"];
            } else {
                if ($current_min > $value) {
                    $current_min = $value;
                }
            }
        }
        return $result;
    }

    private function filterMax($data_pairs) {
        $current_date = null;
        $current_max = -100;
        $result = [];
        foreach ($data_pairs as $pair) {
            $date = $pair["date"];
            $value = $pair["value"];
            if (explode(" ", $date)[0] != $current_date) {
                if ($current_max == -100) {
                    $current_max = $pair["value"];
                }
                $result[] = ["value" => $current_max, "date" => $date];
                $current_date = explode(" ", $date)[0];
                $current_max = $pair["value"];
            } else {
                if ($current_max < $value) {
                    $current_max = $value;
                }
            }
        }
        return $result;
    }
}