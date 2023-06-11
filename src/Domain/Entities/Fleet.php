<?php

namespace Pierrick\FleetParkingManagement\Domain\Entities;

class Fleet
{
    public int $id;
    public string $ownerId;
    private array $vehicles = [];

    public function __construct(string $ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @param Vehicle $vehicle
     * @return void
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }

    public function hasVehicle(Vehicle $vehicle): bool
    {
        return array_filter($this->vehicles, fn (Vehicle $v) => $v->licencePlate === $vehicle->licencePlate) !== [];
    }
}
