<?php

namespace Pierrick\FleetParkingManagement\Domain\UseCases\Vehicle;

use Exception;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;
use Pierrick\FleetParkingManagement\Domain\Services\FleetService;
use Pierrick\FleetParkingManagement\Infra\Repositories\FleetRepository;
use Pierrick\FleetParkingManagement\Infra\Repositories\VehicleRepository;

class RegisterUseCase
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
        private readonly FleetRepository   $fleetRepository,
        private readonly FleetService      $fleetService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function execute(string $fleetId, string $plate): void
    {
        $fleet = $this->fleetRepository->findById($fleetId);
        if ($fleet === null) {
            throw new Exception('Fleet not found');
        }

        $vehicle = new Vehicle($plate);
        if ($this->vehicleRepository->findByPlate($plate) !== null) {
            throw new Exception('Vehicle already registered');
        }

        $this->vehicleRepository->save($vehicle);
        $fleet = $this->fleetService->addVehicle($fleet, $vehicle);
        $this->fleetRepository->addToFleet($fleet, $vehicle);
    }
}
