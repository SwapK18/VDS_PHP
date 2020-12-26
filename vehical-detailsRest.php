<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include('includes/config.php');
error_reporting(1);

// $pid=$_GET['p_vhid'];
// echo $pid;

$input = json_decode(file_get_contents('php://input'));

$varVID = $_GET['vhid'];
// exit();

if(!empty($varVID)){
$query = "SELECT tblvehicles.*,tblbrands.BrandName, tblFuealType.* FROM tblvehicles INNER JOIN tblbrands ON tblbrands.id=tblvehicles.FkVehBrandId INNER JOIN carrental.tblFuealType ON tblFuealType.id=tblvehicles.FkFuelTypeId WHERE tblvehicles.id=".$varVID;

$allCarsDetails = []; 
$query = $dbh->prepare($query);
// $query->bindParam(':vidz',$varVID,PDO::PARAM_INT);
$query->execute();
$result = $query->fetchAll();
$cnt=1;

 if($query->rowCount() > 0)
 {
	foreach($result as $res){
		$id =  (int)$res["id"];
		$BrandName  =  $res["BrandName"];
		$VehiclesTitle =  $res["VehiclesTitle"];
		$VehiclesOverview =  $res["VehiclesOverview"];
		$PricePerDay =  (int)$res["PricePerDay"];
		$ModelYear =  (int)$res["ModelYear"];
		$SeatingCapacity =  (int)$res["SeatingCapacity"];
		$Vimage1 =  $res["Vimage1"];
		$Vimage2 =  $res["Vimage2"];
		$Vimage3 =  $res["Vimage3"];
		$Vimage4 =  $res["Vimage4"];
		$Vimage5 =  $res["Vimage5"];
		$AirConditioner =  $res["AirConditioner"] ? true : false;
		$PowerDoorLocks =  $res["PowerDoorLocks"] ? true : false;
		$AntiLockBrakingSystem =  $res["AntiLockBrakingSystem"] ? true : false;
		$BrakeAssist =  $res["BrakeAssist"] ? true : false;
		$PowerSteering =  $res["PowerSteering"] ? true : false;
		$DriverAirbag =  $res["DriverAirbag"] ? true : false;
        $PassengerAirbag =  $res["PassengerAirbag"] ? true : false;
		$PowerWindows =  $res["PowerWindows"] ? true : false;
		$CDPlayer =  $res["CDPlayer"] ? true : false;
		$CentralLocking =  $res["CentralLocking"] ? true : false;
		$LeatherSeats =  $res["LeatherSeats"] ? true : false;
		$RegDate =  $res["RegDate"];
		$typeName =  $res["typeName"];
		$typeDesc =  $res["typeDesc"];

		$allCarsDetails[] = [
            "id" => $id,
            "BrandName" => $BrandName,
            "VehiclesTitle" => $VehiclesTitle,
            "VehiclesOverview" => $VehiclesOverview,
            "PricePerDay" => $PricePerDay,
            "ModelYear" => $ModelYear,
            "SeatingCapacity" => $SeatingCapacity,
            "Vimage1" => $Vimage1,
            "Vimage2" => $Vimage2,
            "Vimage3" => $Vimage3,
            "Vimage4" => $Vimage4,
            "Vimage5" => $Vimage5,
            "AirConditioner" => $AirConditioner,
            "PowerDoorLocks" => $PowerDoorLocks,
            "AntiLockBrakingSystem" => $AntiLockBrakingSystem,
            "BrakeAssist" => $BrakeAssist,
            "PowerSteering" => $PowerSteering,
            "DriverAirbag" => $DriverAirbag,
            "PassengerAirbag" => $PassengerAirbag,
            "PowerWindows" => $PowerWindows,
            "CDPlayer" => $CDPlayer,
            "CentralLocking" => $CentralLocking,
            "LeatherSeats" => $LeatherSeats,
            "RegDate" => $RegDate,
            "typeName" => $typeName,
            "typeDesc" => $typeDesc
        ];
    }
    $output = json_encode(
        array(
            "message" => "Data found.",
            "status" => true,
            "data" => $allCarsDetails
    ));
	// $output = json_encode($allCarsDetails);
 }
 else
 {
  $output = json_encode(array("message"=>"No data found", "status" => false));
 }
 echo $output;
}
?>
