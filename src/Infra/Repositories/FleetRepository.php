<?php

namespace Pierrick\FleetParkingManagement\Infra\Repositories;

use PDO;
use Pierrick\FleetParkingManagement\Domain\Entities\Fleet;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;

class FleetRepository
{
    public function __construct(
        private readonly PDO $dbConnection,
        private readonly VehicleRepository $vehicleRepository
    ) {
    }

    public function save(Fleet &$fleet): void
    {
        $query = $this->dbConnection->prepare('INSERT INTO fleet (owner_id) VALUES (:ownerId)');
        $query->execute(['ownerId' => $fleet->ownerId]);
        $fleet->id = $this->dbConnection->lastInsertId();
    }

    public function findById(string $fleetId): ?Fleet
    {
        $query = $this->dbConnection->prepare('SELECT id, owner_id FROM fleet WHERE id = :id');
        $query->execute(['id' => $fleetId]);
        $fleetData = $query->fetch();

        $vehicles = $this->vehicleRepository->findByFleetId($fleetId);

        return $fleetData === false ? null : $this->fleetHydrate($fleetData, $vehicles);
    }

    public function addToFleet(Fleet $fleet, Vehicle $vehicle): void
    {
        $query = $this->dbConnection->prepare('INSERT INTO fleet_vehicle (fleet_id, vehicle_plate) VALUES (:fleetId, :licencePlate)');
        $query->execute([
            'fleetId' => $fleet->id,
            'licencePlate' => $vehicle->licencePlate
        ]);
    }

    private function fleetHydrate(mixed $fleetData, $vehicles): Fleet
    {
        $fleet = new Fleet(ownerId: $fleetData['owner_id']);
        $fleet->id = $fleetData['id'];

        foreach ($vehicles as $vehicle) {
            $fleet->addVehicle($vehicle);
        }

        return $fleet;
    }
}
