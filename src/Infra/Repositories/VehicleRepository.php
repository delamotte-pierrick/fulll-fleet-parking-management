<?php

namespace Pierrick\FleetParkingManagement\Infra\Repositories;

use PDO;
use Pierrick\FleetParkingManagement\Domain\Entities\Fleet;
use Pierrick\FleetParkingManagement\Domain\Entities\Location;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;

class VehicleRepository
{
    public function __construct(
        private readonly PDO $dbConnection
    ) {
    }

    public function save(Vehicle &$vehicle): void
    {
        $query = $this->dbConnection->prepare('INSERT INTO vehicle (plate) VALUES (:licencePlate)');
        $query->execute(['licencePlate' => $vehicle->licencePlate]);
    }

    public function updateLocation(Vehicle $vehicle): void
    {
        $query = $this->dbConnection->prepare('UPDATE vehicle SET longitude = :longitude, latitude = :latitude, altitude = :altitude WHERE plate = :licencePlate');
        $query->execute([
            'longitude' => $vehicle->location->longitude,
            'latitude' => $vehicle->location->latitude,
            'altitude' => $vehicle->location->altitude,
            'licencePlate' => $vehicle->licencePlate
        ]);
    }

    public function findByPlate(string $plate): ?Vehicle
    {
        $query = $this->dbConnection->prepare('SELECT plate, longitude, latitude, altitude FROM vehicle WHERE plate = :licencePlate');
        $query->execute(['licencePlate' => $plate]);

        $vehicleData = $query->fetch();

        return $vehicleData === false ? null : $this->vehicleHydrate($vehicleData);
    }

    public function findByFleetId(string $fleetId): array
    {
        $queryVehicle = $this->dbConnection->prepare(
            '
                    SELECT plate, longitude, latitude, altitude
                    FROM vehicle
                    JOIN fleet_vehicle ON vehicle.plate = fleet_vehicle.vehicle_plate
                    WHERE fleet_vehicle.fleet_id = :fleetId
'
        );

        $queryVehicle->execute(['fleetId' => $fleetId]);

        return array_filter(
            array_map(fn (array $vehicleData) => $this->vehicleHydrate($vehicleData), $queryVehicle->fetchAll()),
            fn (?Vehicle $vehicle) => $vehicle !== null
        );
    }

    private function VehicleHydrate(array $vehicleData): Vehicle
    {
        $vehicle = new Vehicle(
            licencePlate: $vehicleData['plate'],
        );

        if ($vehicleData['latitude'] !== null && $vehicleData['longitude'] !== null) {
            $vehicle->location = new Location(
                latitude: $vehicleData['latitude'],
                longitude: $vehicleData['longitude'],
                altitude: $vehicleData['altitude'],
            );
        }

        return $vehicle;
    }
}
