<?php

require __DIR__ . '/../../../vendor/autoload.php';

use DI\Container;
use Pierrick\FleetParkingManagement\Infra\DBConnection;

$container = new Container();
$container->set('PDO', DBConnection::getInstance());

try {
    //Create table fleet
    $container->get('PDO')->exec('CREATE TABLE IF NOT EXISTS fleet (
    id INTEGER PRIMARY KEY,
    owner_id VARCHAR(30) NOT NULL
)');

    //Create table vehicle
    $container->get('PDO')->exec('CREATE TABLE IF NOT EXISTS vehicle (
    plate VARCHAR(30) PRIMARY KEY,
    longitude FLOAT(30) NULL,
    latitude FLOAT(30) NULL,
    altitude FLOAT(30) NULL
)');

    //Create table fleet_vehicle
    $container->get('PDO')->exec('CREATE TABLE IF NOT EXISTS fleet_vehicle (
    fleet_id INTEGER,
    vehicle_plate VARCHAR(30),
    PRIMARY KEY (fleet_id, vehicle_plate),
    FOREIGN KEY (fleet_id) REFERENCES fleet(id),
    FOREIGN KEY (vehicle_plate) REFERENCES vehicle(plate)
)');
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    return 1;
}
