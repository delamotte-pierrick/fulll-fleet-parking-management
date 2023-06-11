<?php

namespace Pierrick\FleetParkingManagement\Domain\Entities;

class Location
{
    public float $latitude;
    public float $longitude;
    public ?float $altitude;

    public function __construct(float $latitude, float $longitude, ?float $altitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }
}
