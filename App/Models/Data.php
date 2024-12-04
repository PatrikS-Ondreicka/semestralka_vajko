<?php

namespace App\Models;

use App\Datatypes\DateTime;

class Data extends \App\Core\Model
{
    const MIM_TEMP = -90.0;
    const MAX_TEMP = 57.0;
    const MIN_HUM = 0.0;
    const MAX_HUM = 100.0;
    const MIN_WIND_SPEED = 0.0;
    const MIN_PRECIP = 0.0;

    const WIND_DIRECTION_VALUES = array('N', 'S', 'E', 'W', 'NE', 'NW', 'SE', 'SW');

    protected ?int $id = null;
    protected ?string $date = null;
    protected ?float $temperature = null;
    protected ?float $humidity = null;
    protected ?float $wind_speed = null;
    protected ?string $wind_direction = null;
    protected ?float $precipitation = null;
    protected ?int $location = null;
    protected ?int $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(?float $humidity): void
    {
        $this->humidity = $humidity;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }


    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?float $wind_speed): void
    {
        $this->wind_speed = $wind_speed;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(?string $wind_direction): void
    {
        $this->wind_direction = $wind_direction;
    }

    public function getPrecipitation(): ?float
    {
        return $this->precipitation;
    }

    public function setPrecipitation(?float $precipitation): void
    {
        $this->precipitation = $precipitation;
    }

    public function getLocation(): ?int
    {
        return $this->location;
    }

    public function setLocation(?int $location): void
    {
        $this->location = $location;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): void
    {
        $this->user = $user;
    }
    
    public static function getTableName() : string
    {
        return "data";
    }
}