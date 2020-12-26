<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(0);

$input = json_decode(file_get_contents('php://input'));

$vehicalIdz = (int)$input->vehicleId;
$vehicalTitle = $input->vehicleTitle;

$vehicalfuealType = (int)$input->fuealType;
$vehicalbrandName = $input->brandName;
$vehicalOverview = $input->vehicleOverview;
$vehicalPricePerDay = $input->pricePerDay;
$vehicalModelYear = $input->modelYear;
$vehicalSeatingCapacity = $input->seatingCapacity;
$vehicalAirConditioner = $input->airConditioner;
$vehicalPowerDoorLocks = $input->powerDoorLocks;
$vehicalAntiLockBrakingSystem = $input->antiLockBrakingSystem;
$vehicalBrakeAssist = $input->brakeAssist;
$vehicalPowerSteering = $input->powerSteering;
$vehicalDriverAirbag = $input->driverAirbag;
$vehicalPassengerAirbag = $input->passengerAirbag;
$vehicalPowerWindows = $input->powerWindows;
$vehicalCDPlayer = $input->cdPlayer;
$vehicalCentralLocking = $input->centralLocking;
$vehicalCrashSensor = $input->crashSensor;
$vehicalLeatherSeats = $input->leatherSeats;

$sql = "UPDATE tblvehicles SET VehiclesTitle=:vTitle, FkVehBrandId=:vBrandID, VehiclesOverview=:vOverview, PricePerDay=:vPricePerDay, FkFuelTypeId=:vFuelTypeId, ModelYear=:vModelYear, SeatingCapacity=:vSeatingCapacity, AirConditioner=:vAirConditioner, PowerDoorLocks=:vPowerDoorLocks, AntiLockBrakingSystem=:vAntiLockBrakingSystem, BrakeAssist=:vBrakeAssist, PowerSteering=:vPowerSteering, DriverAirbag=:vDriverAirbag, PassengerAirbag=:vPassengerAirbag, PowerWindows=:vPowerWindows, CDPlayer=:vCDPlayer, CentralLocking=:vCentralLocking, CrashSensor=:vCrashSensor, LeatherSeats=:vLeatherSeats WHERE id=:vID";

$query = $dbh->prepare($sql);
$query->bindParam(':vID', $vehicalIdz, PDO::PARAM_INT);
$query->bindParam(':vTitle', $vehicalTitle, PDO::PARAM_STR);
$query->bindParam(':vBrandID', $vehicalbrandName, PDO::PARAM_STR);
$query->bindParam(':vOverview', $vehicalOverview, PDO::PARAM_STR);
$query->bindParam(':vPricePerDay', $vehicalPricePerDay, PDO::PARAM_STR);
$query->bindParam(':vFuelTypeId', $vehicalfuealType, PDO::PARAM_INT);
$query->bindParam(':vModelYear', $vehicalModelYear, PDO::PARAM_STR);
$query->bindParam(':vSeatingCapacity', $vehicalSeatingCapacity, PDO::PARAM_STR);
$query->bindParam(':vAirConditioner', $vehicalAirConditioner, PDO::PARAM_BOOL);
$query->bindParam(':vPowerDoorLocks', $vehicalPowerDoorLocks, PDO::PARAM_BOOL);
$query->bindParam(':vAntiLockBrakingSystem', $vehicalAntiLockBrakingSystem, PDO::PARAM_BOOL);
$query->bindParam(':vBrakeAssist', $vehicalBrakeAssist, PDO::PARAM_BOOL);
$query->bindParam(':vPowerSteering', $vehicalPowerSteering, PDO::PARAM_BOOL);
$query->bindParam(':vDriverAirbag', $vehicalDriverAirbag, PDO::PARAM_BOOL);
$query->bindParam(':vPassengerAirbag', $vehicalPassengerAirbag, PDO::PARAM_BOOL);
$query->bindParam(':vPowerWindows', $vehicalPowerWindows, PDO::PARAM_BOOL);
$query->bindParam(':vCDPlayer', $vehicalCDPlayer, PDO::PARAM_BOOL);
$query->bindParam(':vCentralLocking', $vehicalCentralLocking, PDO::PARAM_BOOL);
$query->bindParam(':vCrashSensor', $vehicalCrashSensor, PDO::PARAM_BOOL);
$query->bindParam(':vLeatherSeats', $vehicalLeatherSeats, PDO::PARAM_BOOL);

if ($query->execute())
{
    $output = json_encode(array(
        "message" => "Vehical updated successfully.",
        "status" => true
    ));
    http_response_code(200);
}
else
{
    $output = json_encode(array(
        "message" => "Vehical updation failed",
        "status" => false
    ));
    http_response_code(401);

}
echo ($output);
?>