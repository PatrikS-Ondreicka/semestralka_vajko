<?php

class Data extends \App\Core\Model
{
    protected ?int $id = null;
    protected ?DateTime $date = null;
    protected ?float $temperature = null;
    protected ?float $humidity = null;
    protected ?float $wind_speed = null;

    protected ?string $wind_direction = null;

    protected ?float $precipitation = null;

    protected ?Location $location = null;

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(?float $humidity): void
    {
        $this->humidity = $humidity;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?DateTime $date): void
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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }

}