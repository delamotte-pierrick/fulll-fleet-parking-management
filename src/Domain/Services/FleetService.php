<?php

namespace Pierrick\FleetParkingManagement\Domain\Services;

use Exception;
use Pierrick\FleetParkingManagement\Domain\Entities\Fleet;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;

class FleetService
{
    public function create(string $ownerId): Fleet
    {
        return new Fleet(
            ownerId: $ownerId
        );
    }

    /**
     * @throws Exception
     */
    public function addVehicle(Fleet $fleet, Vehicle $vehicle): Fleet
    {
        if ($fleet->hasVehicle($vehicle)) {
            throw new Exception('Vehicle already exists');
        }

        $fleet->addVehicle($vehicle);

        return $fleet;
    }
}
