# Fleet Parking Management

## To install the application:
```bash
$ composer install
$ composer dump-autoload -o
$ php src/App/Commands/db.php
```

## Available commands :
```bash
$ php src/App/Commands/fleet.php create <userid>
$ php src/App/Commands/fleet.php register-vehicle <fleetId> <vehiclePlateNumber>
$ php src/App/Commands/fleet.php localize-vehicle <fleetId> <vehiclePlateNumber> <longitude> <latitude> [altitude]
```

## CI/CD Process

**In case we need to implement a CI/CD Process, we can use the following commands:**
```bash
$ composer install
$ composer dump-autoload -o
$ ./vendor/bin/php-cs-fixer fix --dry-run --diff --verbose
$ ./vendor/bin/phpunit
$ ./vendor/bin/behat --strict --tags @critical
```