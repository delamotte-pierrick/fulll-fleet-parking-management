<?php

namespace Pierrick\FleetParkingManagement\Domain\UseCases\Vehicle;

use Exception;
use Pierrick\FleetParkingManagement\Domain\Entities\Location;
use Pierrick\FleetParkingManagement\Domain\Services\VehicleService;
use Pierrick\FleetParkingManagement\Infra\Repositories\VehicleRepository;

class LocalizeUseCase
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
        private readonly VehicleService $vehicleService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(string $plate, float $longitude, float $latitude, ?float $altitude = null): void
    {
        $vehicle = $this->vehicleRepository->findByPlate($plate);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found');
        }

        $location = new Location($longitude, $latitude, $altitude);
        $this->vehicleService->parkAt($vehicle, $location);

        $this->vehicleRepository->updateLocation($vehicle);
    }
}
