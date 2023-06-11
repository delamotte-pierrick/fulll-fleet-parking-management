<?php

namespace Pierrick\FleetParkingManagement\Domain\Entities;

class Vehicle
{
    public string $licencePlate;
    public ?Location $location = null;

    public function __construct(string $licencePlate)
    {
        $this->licencePlate = $licencePlate;
    }
}
