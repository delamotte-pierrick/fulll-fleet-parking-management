<?php

namespace Pierrick\FleetParkingManagement\Domain\UseCases\Fleet;

use Pierrick\FleetParkingManagement\Domain\Services\FleetService;
use Pierrick\FleetParkingManagement\Infra\Repositories\FleetRepository;

class CreateUseCase
{
    public function __construct(
        private readonly FleetRepository $fleetRepository,
        private readonly FleetService $fleetService
    ) {
    }

    public function execute(string $ownerId): int
    {
        $fleet = $this->fleetService->create($ownerId);
        $this->fleetRepository->save($fleet);

        return $fleet->id;
    }
}
