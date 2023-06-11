<?php

namespace Pierrick\FleetParkingManagement\Domain\Services;

use Pierrick\FleetParkingManagement\Domain\Entities\Location;

class LocationService
{
    public function create(float $longitude, float $latitude, ?float $altitude = null): Location
    {
        return new Location(
            $longitude,
            $latitude,
            $altitude
        );
    }

    public function areSame(Location $location1, Location $location2): bool
    {
        return $location1->longitude === $location2->longitude
            && $location1->latitude === $location2->latitude
            && $location1->altitude === $location2->altitude;
    }
}
