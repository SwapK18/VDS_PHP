<?php
require_once ("./includes/config.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);

$images = array();
$folderPath = "uploads/";


$file_namesOne = $_FILES["imageOne"]["name"][0];
// $file_namesTwo = $_FILES["imageTwo"]["name"][0];
// $file_namesThree = $_FILES["imageThree"]["name"][0];
// $file_namesFour = $_FILES["imageFour"]["name"][0];
// $file_namesFive = $_FILES["imageFive"]["name"][0];
    
    // file one upload
    $image_infoOne = explode(".", $file_namesOne);
    $image_typeOne = end($image_infoOne);
    $original_file_nameOne = pathinfo($file_namesOne, PATHINFO_FILENAME);
    $file_urlOne = $original_file_nameOne . "-" . date("YmdHis") . "." . $image_typeOne;
    move_uploaded_file($_FILES["imageOne"]["tmp_name"][0], $folderPath . $file_urlOne);


    // file two upload
    // $image_infoTwo = explode(".", $file_namesTwo);
    // $image_typeTwo = end($image_infoTwo);
    // $original_file_nameTwo = pathinfo($file_namesTwo, PATHINFO_FILENAME);
    // $file_urlTwo = $original_file_nameTwo . "-" . date("YmdHis") . "." . $image_typeTwo;
    // move_uploaded_file($_FILES["imageTwo"]["tmp_name"][0], $folderPath . $file_urlTwo);

    // file one upload
    // $image_infoThree = explode(".", $file_namesThree);
    // $image_typeThree = end($image_infoThree);
    // $original_file_nameThree = pathinfo($file_namesThree, PATHINFO_FILENAME);
    // $file_urlThree = $original_file_nameThree . "-" . date("YmdHis") . "." . $image_typeThree;
    // move_uploaded_file($_FILES["imageThree"]["tmp_name"][0], $folderPath . $file_urlThree);

    // file one upload
    // $image_infoFour = explode(".", $file_namesFour);
    // $image_typeFour = end($image_infoFour);
    // $original_file_nameFour = pathinfo($file_namesFour, PATHINFO_FILENAME);
    // $file_urlFour = $original_file_nameFour . "-" . date("YmdHis") . "." . $image_typeFour;
    // move_uploaded_file($_FILES["file"]["imageFour"][0], $folderPath . $file_urlFour);

    // file one upload
    // $image_infoFive = explode(".", $file_namesFive);
    // $image_typeFive = end($image_infoFive);
    // $original_file_nameFive = pathinfo($file_namesFive, PATHINFO_FILENAME);
    // $file_urlFive = $original_file_nameFive . "-" . date("YmdHis") . "." . $image_typeFive;
    // move_uploaded_file($_FILES["imageFive"]["tmp_name"][0], $folderPath . $file_urlFive);


// $brandName = $_REQUEST['brandName'];
// $pricePerDay = $_REQUEST['pricePerDay'];
// $modelYear = $_REQUEST['modelYear'];
// $fuelType = $_REQUEST['fuealType'];
// $seatingCapacity = $_REQUEST['seatingCapacity'];
// $airConditioner = $_REQUEST['airConditioner'];
// $powerDoorLocks = $_REQUEST['powerDoorLocks'];
// $antiLockBrakingSystem = $_REQUEST['antiLockBrakingSystem'];
// $brakeAssist = $_REQUEST['brakeAssist'];
// $powerSteering = $_REQUEST['powerSteering'];
// $driverAirbag = $_REQUEST['driverAirbag'];
// $passengerAirbag = $_REQUEST['passengerAirbag'];
// $powerWindows = $_REQUEST['powerWindows'];
// $cdPlayer = $_REQUEST['cdPlayer'];
// $centralLocking = $_REQUEST['centralLocking'];
// $crashSensor = $_REQUEST['crashSensor'];
// $leatherSeats = $_REQUEST['leatherSeats'];
// $vehicleTitle = $_REQUEST['vehicleTitle'];

$vehicleTitle = $_REQUEST['vtitle'];
$vehicleOverview = $_REQUEST['vOverview'];


$output = "";

// $sql = "INSERT INTO tblvehicles(VehiclesTitle,FkVehBrandId,VehiclesOverview,PricePerDay,FkFuelTypeId,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,PowerDoorLocks,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CDPlayer,CentralLocking,CrashSensor,LeatherSeats) VALUES(:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:powerdoorlocks,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:cdplayer,:centrallocking,:crashcensor,:leatherseats)";


// $sql = "INSERT INTO tblvehicles(VehiclesTitle, VehiclesOverview, Vimage1,Vimage2,Vimage3,Vimage4,Vimage5) VALUES(:vehicletitle, :vehicleoverview,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5)";
$sql = "INSERT INTO tblvehicles(VehiclesTitle, VehiclesOverview, Vimage1) VALUES('".$vehicleTitle."','".$vehicleOverview."','".$file_urlOne."')";

print_r($original_file_nameOne);
exit();
$query = $dbh->prepare($sql);
// $query->bindParam(':vehicletitle',$vehicleTitle);
// $query->bindParam(':vehicleoverview',$vehicleOverview);
// $query->bindParam(':vimage1',$file_urlOne);
// $query->bindParam(':vimage2',$file_urlTwo);
// $query->bindParam(':vimage3',$file_urlThree);
// $query->bindParam(':vimage4',$file_urlFour);
// $query->bindParam(':vimage5',$file_urlFive);


/*$query->bindParam(':vehicletitle',$vehicleTitle,PDO::PARAM_STR);
$query->bindParam(':brand',$brandName,PDO::PARAM_INT);
$query->bindParam(':vehicleoverview',$vehicleOverview,PDO::PARAM_STR);
$query->bindParam(':priceperday',$pricePerDay,PDO::PARAM_INT);
$query->bindParam(':fueltype',$fuelType,PDO::PARAM_INT);
$query->bindParam(':modelyear',$modelYear,PDO::PARAM_INT);
$query->bindParam(':seatingcapacity',$seatingCapacity,PDO::PARAM_INT);
$query->bindParam(':vimage1',$imgOne,PDO::PARAM_STR);
$query->bindParam(':vimage2',$imgTwo,PDO::PARAM_STR);
$query->bindParam(':vimage3',$imgThree,PDO::PARAM_STR);
$query->bindParam(':vimage4',$imgFour,PDO::PARAM_STR);
$query->bindParam(':vimage5',$imgFive,PDO::PARAM_STR);
$query->bindParam(':airconditioner',$airConditioner,PDO::PARAM_STR);
$query->bindParam(':powerdoorlocks',$powerDoorLocks,PDO::PARAM_STR);
$query->bindParam(':antilockbrakingsys',$antiLockBrakingSystem,PDO::PARAM_STR);
$query->bindParam(':brakeassist',$brakeAssist,PDO::PARAM_STR);
$query->bindParam(':powersteering',$powerSteering,PDO::PARAM_STR);
$query->bindParam(':driverairbag',$driverAirbag,PDO::PARAM_STR);
$query->bindParam(':passengerairbag',$passengerAirbag,PDO::PARAM_STR);
$query->bindParam(':powerwindow',$powerWindows,PDO::PARAM_STR);
$query->bindParam(':cdplayer',$cdPlayer,PDO::PARAM_STR);
$query->bindParam(':centrallocking',$centralLocking,PDO::PARAM_STR);
$query->bindParam(':crashcensor',$crashSensor,PDO::PARAM_STR);
$query->bindParam(':leatherseats',$leatherSeats,PDO::PARAM_STR);*/

$query->execute();
$lastInsertId = $dbh->lastInsertId();


if ($lastInsertId)
{
    $output = json_encode(array(
        "message" => "Vehicle posted successfully.",
        "status" => true
    ));
    http_response_code(200);
}
else
{
    $error = "Something went wrong. Please try again";
    $output = json_encode(array(
        "message" => "Something went wrong. Please try again",
        "status" => false
    ));
    // http_response_code(401);
}
echo ($output);
?>