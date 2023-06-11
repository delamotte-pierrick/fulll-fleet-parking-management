<?php

require __DIR__ . '/../../../vendor/autoload.php';

use DI\Container;
use Pierrick\FleetParkingManagement\Domain\UseCases\Fleet\CreateUseCase;
use Pierrick\FleetParkingManagement\Domain\UseCases\Vehicle\LocalizeUseCase;
use Pierrick\FleetParkingManagement\Domain\UseCases\Vehicle\RegisterUseCase;
use Pierrick\FleetParkingManagement\Infra\DBConnection;

$container = new Container();
$container->set('PDO', DBConnection::getInstance());

try {
    switch ($argv[1]) {
        case 'create':
            if (!isset($argv[2])) {
                throw new Exception('user id is required');
            }

            $fleetId = $container->get(CreateUseCase::class)->execute($argv[2]);
            echo $fleetId . PHP_EOL;

            return 0;
        case 'register-vehicle':
            if (!isset($argv[2])) {
                throw new Exception('fleet id is required');
            }
            if (!isset($argv[3])) {
                throw new Exception('plate is required');
            }

            $container->get(RegisterUseCase::class)->execute($argv[2], $argv[3]);

            return 0;

        case 'localize-vehicle':
            if (!isset($argv[2])) {
                throw new Exception('fleet id is required');
            }
            if (!isset($argv[3])) {
                throw new Exception('plate is required');
            }
            if (!isset($argv[4])) {
                throw new Exception('longitude is required');
            }
            if (!isset($argv[5])) {
                throw new Exception('latitude is required');
            }

            $container->get(LocalizeUseCase::class)->execute($argv[3], $argv[4], $argv[5], $argv[6] ?? null);

            return 0;
        default:
            throw new Exception('command not found');
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    return 1;
}
