<?php

use Behat\Behat\Context\Context;
use Pierrick\FleetParkingManagement\Domain\Entities\Fleet;
use Pierrick\FleetParkingManagement\Domain\Entities\Location;
use Pierrick\FleetParkingManagement\Domain\Entities\Vehicle;
use Pierrick\FleetParkingManagement\Domain\Services\FleetService;
use Pierrick\FleetParkingManagement\Domain\Services\LocationService;
use Pierrick\FleetParkingManagement\Domain\Services\VehicleService;

class FeatureContext implements Context
{
    private Fleet $fleet;
    private Fleet $anotherFleet;
    private Vehicle $vehicle;
    private ?Exception $exception = null;
    private Location $location;

    private FleetService $fleetService;
    private VehicleService $vehicleService;
    private LocationService $locationService;

    public function __construct()
    {
        $this->locationService = new LocationService();
        $this->fleetService = new FleetService();
        $this->vehicleService = new VehicleService(
            locationService: $this->locationService
        );
    }

    /**
     * @Given /^my fleet$/
     */
    public function myFleet(): void
    {
        $this->fleet = $this->fleetService->create('1');
    }

    /**
     * @Given /^a vehicle$/
     */
    public function aVehicle(): void
    {
        $this->vehicle = $this->vehicleService->create('AA-123-AA');
    }

    /**
     * @When /^I register this vehicle into my fleet$/
     * @throws Exception
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $this->fleet = $this->fleetService->addVehicle($this->fleet, $this->vehicle);
    }

    /**
     * @Then /^this vehicle should be part of my vehicle fleet$/
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        if (!$this->fleet->hasVehicle($this->vehicle)) {
            throw new RuntimeException('This vehicle is not part of my vehicle fleet');
        }
    }

    /**
     * @Given /^I have registered this vehicle into my fleet$/
     * @throws Exception
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->fleetService->addVehicle($this->fleet, $this->vehicle);
    }

    /**
     * @When /^I try to register this vehicle into my fleet$/
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->fleet = $this->fleetService->addVehicle($this->fleet, $this->vehicle);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then /^I should be informed this vehicle has already been registered into my fleet$/
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        if ($this->exception === null) {
            throw new RuntimeException('I should be informed this this vehicle has already been registered into my fleet');
        }
    }

    /**
     * @Given /^the fleet of another user$/
     */
    public function theFleetOfAnotherUser(): void
    {
        $this->anotherFleet = $this->fleetService->create('2');
    }

    /**
     * @Given /^this vehicle has been registered into the other user's fleet$/
     * @throws Exception
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserSFleet(): void
    {
        $this->fleetService->addVehicle($this->anotherFleet, $this->vehicle);
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $this->location = $this->locationService->create(0, 0);
    }

    /**
     * @When /^I park my vehicle at this location$/
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->vehicle = $this->vehicleService->parkAt($this->vehicle, $this->location);
    }

    /**
     * @Then /^the known location of my vehicle should verify this location$/
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        if (!$this->locationService->areSame($this->vehicle->location, $this->location)) {
            throw new RuntimeException('The known location of my vehicle should verify this location');
        }
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     * @throws Exception
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->vehicle = $this->vehicleService->parkAt($this->vehicle, $this->location);
    }

    /**
     * @When /^I try to park my vehicle at this location$/
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->vehicle = $this->vehicleService->parkAt($this->vehicle, $this->location);
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if ($this->exception === null) {
            throw new RuntimeException('I should be informed that my vehicle is already parked at this location');
        }
    }
}
