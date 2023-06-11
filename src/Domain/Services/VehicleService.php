<?php

namespace Pierrick\FleetParkingManagement\Domain\Services;

use Exception;
use Pierrick\FleetParkingManagement\Domain\Entities\Location;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;

class VehicleService
{
    public function __construct(
        private readonly LocationService $locationService
    ) {
    }

    public function create(string $licencePlate): Vehicle
    {
        return new Vehicle(
            licencePlate: $licencePlate
        );
    }

    /**
     * @throws Exception
     */
    public function parkAt(Vehicle $vehicle, Location $location): Vehicle
    {
        if ($vehicle->location !== null && $this->locationService->areSame($vehicle->location, $location)) {
            throw new Exception('Vehicle is already parked at this location');
        }

        $vehicle->location = $location;

        return $vehicle;
    }
}
