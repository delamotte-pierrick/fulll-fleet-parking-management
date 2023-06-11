<?php

namespace Pierrick\FleetParkingManagement\Infra;

use PDO;

class DBConnection
{
    public const DSN = 'sqlite:' . __DIR__ . '/../../data/db.sqlite';

    private static $pdoInstance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$pdoInstance == null) {
            self::$pdoInstance = new PDO(
                dsn: self::DSN,
                options: [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$pdoInstance;
    }
}
