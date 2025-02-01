<?php

namespace App\Models;

class Location extends \App\Core\Model
{
    protected ?int $id = null;

    protected ?float $lon = null;
    protected ?float $lat = null;

    protected ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(?float $lon): void
    {
        $this->lon = $lon;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): void
    {
        $this->lat = $lat;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public static function asValueKeyPairs(): array
    {
        $locations = Location::getAll();
        $result = [];
        foreach ($locations as $location) {
            $result[$location->getId()] = $location->getName();
        }
        return $result;
    }
}