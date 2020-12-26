<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);
include ('includes/config.php');

$input = json_decode(file_get_contents('php://input'));
$vehidz = $input->vehId;

$assocDataArray = array();
if (isset($vehidz))
{
    $query = "SELECT  tblbrands.*,tblFuealType.*,tblvehicles.* FROM tblvehicles INNER JOIN tblbrands ON tblvehicles.FkVehBrandId = tblbrands.id INNER JOIN tblFuealType ON tblvehicles.FkFuelTypeId = tblFuealType.id WHERE tblvehicles.id='" . $vehidz . "'";
}
else if (!isset($vehidz))
{
    $query = "SELECT  tblbrands.*,tblFuealType.*,tblvehicles.* FROM tblvehicles INNER JOIN tblbrands ON tblvehicles.FkVehBrandId = tblbrands.id INNER JOIN tblFuealType ON tblvehicles.FkFuelTypeId = tblFuealType.id WHERE 1";
}
$statement = $dbh->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    foreach ($result as $res)
    {
        $id = (int)$res["id"];
        $VehiclesTitle = $res["VehiclesTitle"];
        $FkVehBrandId = $res["FkVehBrandId"];
        $FkVehBrandName = $res["BrandName"];
        $VehiclesOverview = $res["VehiclesOverview"];
        $PricePerDay = $res["PricePerDay"];
        $FkFuelTypeId = $res["FkFuelTypeId"];
        $FkFuelTypeName = $res["typeName"];
        $ModelYear = $res["ModelYear"];
        $SeatingCapacity = $res["SeatingCapacity"];
        $Vimage1 = $res["Vimage1"];
        $Vimage2 = $res["Vimage2"];
        $Vimage3 = $res["Vimage3"];
        $Vimage4 = $res["Vimage4"];
        $Vimage5 = $res["Vimage5"];
        $AirConditioner = $res["AirConditioner"];
        $PowerDoorLocks = $res["PowerDoorLocks"];
        $AntiLockBrakingSystem = $res["AntiLockBrakingSystem"];
        $BrakeAssist = $res["BrakeAssist"];
        $PowerSteering = $res["PowerSteering"];

        $DriverAirbag = $res["DriverAirbag"];
        $PassengerAirbag = $res["PassengerAirbag"];
        $PowerWindows = $res["PowerWindows"];
        $CDPlayer = $res["CDPlayer"];
        $CentralLocking = $res["CentralLocking"];
        $CrashSensor = $res["CrashSensor"];
        $LeatherSeats = $res["LeatherSeats"];
        $RegDate = $res["RegDate"];
        $UpdationDate = $res["UpdationDate"];
        $CreationDate = $res["CreationDate"];

        $assocDataArray[] = ["id" => $id, "VehiclesTitle" => $VehiclesTitle, "FkVehBrandId" => $FkVehBrandId, "BrandName" => $FkVehBrandName, "VehiclesOverview" => $VehiclesOverview, "PricePerDay" => $PricePerDay, "FkFuelTypeId" => $FkFuelTypeId, "FuelTypeName" => $FkFuelTypeName, "ModelYear" => $ModelYear, "SeatingCapacity" => $SeatingCapacity, "Vimage1" => $Vimage1, "Vimage2" => $Vimage2, "Vimage3" => $Vimage3, "Vimage4" => $Vimage4, "Vimage5" => $Vimage5, "AirConditioner" => $AirConditioner, "PowerDoorLocks" => $PowerDoorLocks, "AntiLockBrakingSystem" => $AntiLockBrakingSystem, "BrakeAssist" => $BrakeAssist, "PowerSteering" => $PowerSteering, "DriverAirbag" => $DriverAirbag, "PassengerAirbag" => $PassengerAirbag, "PowerWindows" => $PowerWindows, "CDPlayer" => $CDPlayer, "CentralLocking" => $CentralLocking, "CrashSensor" => $CrashSensor, "LeatherSeats" => $LeatherSeats, "RegDate" => $RegDate, "UpdationDate" => $UpdationDate, "CreationDate" => $CreationDate];
    }
    echo $json = json_encode($assocDataArray);
}
?>