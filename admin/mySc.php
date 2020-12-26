<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(1);


    $query = "SELECT * FROM tblvehicles";


$allUsers = array();
$images= array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{

	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {  		
    			$imgs = explode(",", $row['images']);

    	    // $allUsers["id"] = $row["id"];
         //    $allUsers["VehiclesTitle"] = $row["VehiclesTitle"]; 
         //    $allUsers["FkVehBrandId"] = $row["FkVehBrandId"];
         //    $allUsers["VehiclesOverview"] = $row["VehiclesOverview"];
         //    $allUsers["PricePerDay"] =  $row["PricePerDay"];
         //    $allUsers["FkFuelTypeId"] =  $row["FkFuelTypeId"];
         //    $allUsers["ModelYear"] =  $row["ModelYear"];
         //    $allUsers["SeatingCapacity"] =  $row["SeatingCapacity"];
         //    $allUsers["AirConditioner"] =  $row["AirConditioner"];
         //    $allUsers["PowerDoorLocks"] =  $row["PowerDoorLocks"];
         //    $allUsers["AntiLockBrakingSystem"] =  $row["AntiLockBrakingSystem"];
         //    $allUsers["BrakeAssist"] =  $row["BrakeAssist"];
         //    $allUsers["PowerSteering"] =  $row["PowerSteering"];
         //    $allUsers["DriverAirbag"] =  $row["DriverAirbag"];
         //    $allUsers["PassengerAirbag"] =  $row["PassengerAirbag"];
         //    $allUsers["PowerWindows"] =  $row["PowerWindows"];
         //    $allUsers["CDPlayer"] =  $row["CDPlayer"];
         //    $allUsers["CentralLocking"] =  $row["CentralLocking"];
         //    $allUsers["CrashSensor"] =  $row["CrashSensor"];
         //    $allUsers["LeatherSeats"] =  $row["LeatherSeats"];
         //    $allUsers["RegDate"] =  $row["RegDate"];
         //    $allUsers["UpdationDate"] =  $row["UpdationDate"];
         //    $allUsers["images"] = $row["images"];
            // $allUsers["imgs"] = $imgs;

            $allUsers[] = $row;
            
            array_push($allUsers, $imgs);


    }
    // http_response_code(200);
    $output = json_encode(array(
        "message" => "Users found.",
        "status" => true,
        "data" => $allUsers
    ));
    
}
else
{
    $output = json_encode(array(
        "message" => "No users found",
        "status" => false
    ));
}
var_dump($allUsers);
?>
