<?php
require_once ("./includes/config.php");
require_once "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,  X-Requested-With");
error_reporting(1);

$output = null;
function validateJWT()
{
    $key = "ADMINCARRENTAL";
    // get posted data
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

    $arr = explode(" ", $authHeader);

    // get jwt
    // $jwt = isset($temp_header[1]) ? $temp_header[1] : "";
    $jwt = $arr[1];

    if ($jwt)
    {

        // if decode succeed, show user details
        try
        {
            // decode jwt
            // $decoded = JWT::decode($jwt, $key, array('HS256'));
            $decoded = JWT::decode($jwt, $key, array(
                'HS256'
            ));

            // show user details
            return true;
        }

        // if decode fails, it means jwt is invalid
        catch(Exception $e)
        {
            // tell the user access denied  & show error message
            return false;
        }
    }

    // show error message if jwt is empty
    else
    {
        // tell the user access denied
        return false;
    }
}

$allowUserAccess = validateJWT();

if ($allowUserAccess === true)
{

    $folderPath = "../assets/images/";
    $file_nameOnesOne = isset($_FILES["imageOne"]["name"]) ? $_FILES["imageOne"]["name"] : null;
    $file_nameOnesTwo = isset($_FILES["imageTwo"]["name"]) ? $_FILES["imageTwo"]["name"] : null;
    $file_nameOnesThree = isset($_FILES["imageThree"]["name"]) ? $_FILES["imageThree"]["name"] : null;
    $file_nameOnesFour = isset($_FILES["imageFour"]["name"]) ? $_FILES["imageFour"]["name"] : null;
    $file_nameOnesFive = isset($_FILES["imageFive"]["name"]) ? $_FILES["imageFive"]["name"] : null;

    if (isset($file_nameOnesOne))
    {
        $extOne = explode(".", $file_nameOnesOne);
        $newfilenameOne = $extOne[0] . "-" . date("His") . '.' . end($extOne);
        move_uploaded_file($_FILES["imageOne"]["tmp_name"], $folderPath . $newfilenameOne);
    }

    if (isset($file_nameOnesTwo))
    {
        $extTwo = explode(".", $file_nameOnesTwo);
        $newfilenameTwo = $extTwo[0] . "-" . date("His") . '.' . end($extTwo);
        move_uploaded_file($_FILES["imageTwo"]["tmp_name"], $folderPath . $newfilenameTwo);
    }

    if (isset($file_nameOnesThree))
    {
        $extThree = explode(".", $file_nameOnesThree);
        $newfilenameThree = $extThree[0] . "-" . date("His") . '.' . end($extThree);
        move_uploaded_file($_FILES["imageThree"]["tmp_name"], $folderPath . $newfilenameThree);
    }

    if (isset($file_nameOnesFour))
    {
        $extFour = explode(".", $file_nameOnesFour);
        $newfilenameFour = $extFour[0] . "-" . date("His") . '.' . end($extFour);
        move_uploaded_file($_FILES["imageFour"]["tmp_name"], $folderPath . $newfilenameFour);
    }

    if (isset($file_nameOnesFive))
    {
        $extFive = explode(".", $file_nameOnesFive);
        $newfilenameFive = $extFive[0] . "-" . date("His") . '.' . end($extFive);
        move_uploaded_file($_FILES["imageFive"]["tmp_name"], $folderPath . $newfilenameFive);
    }

    $vTitle = $_REQUEST['vTitle'];
    $brandName = $_REQUEST['brandName'];
    $pricePerDay = $_REQUEST['pricePerDay'] ? $_REQUEST['pricePerDay'] : null;
    $modelYear = $_REQUEST['modelYear'] ? $_REQUEST['modelYear'] : null;
    $seatingCapacity = (int)$_REQUEST['seatingCapacity'];
    $fuealType = $_REQUEST['fuealType'] ? $_REQUEST['fuealType'] : null;
    $vehicleOverview = $_REQUEST['vOverview'] ? $_REQUEST['vOverview'] : null;

    $airConditioner = ($_REQUEST['airConditioner'] == 'false') ? 0 : 1;
    $cdPlayer = ($_REQUEST['cdPlayer'] == 'false') ? 0 : 1;
    $powerDoorLocks = ($_REQUEST['powerDoorLocks'] == 'false') ? 0 : 1;
    $antiLockBrakingSystem = ($_REQUEST['antiLockBrakingSystem'] == 'false') ? 0 : 1;
    $brakeAssist = ($_REQUEST['brakeAssist'] == 'false') ? 0 : 1;
    $powerSteering = ($_REQUEST['powerSteering'] == 'false') ? 0 : 1;
    $driverAirbag = ($_REQUEST['driverAirbag'] == 'false') ? 0 : 1;
    $passengerAirbag = ($_REQUEST['passengerAirbag'] == 'false') ? 0 : 1;
    $powerWindows = ($_REQUEST['powerWindows'] == 'false') ? 0 : 1;
    $centralLocking = ($_REQUEST['centralLocking'] == 'false') ? 0 : 1;
    $crashSensor = ($_REQUEST['crashSensor'] == 'false') ? 0 : 1;
    $leatherSeats = ($_REQUEST['leatherSeats'] == 'false') ? 0 : 1;

    $sql = "INSERT INTO tblvehicles(VehiclesTitle, FkVehBrandId, VehiclesOverview, PricePerDay, FkFuelTypeId, ModelYear, SeatingCapacity, Vimage1, Vimage2, Vimage3, Vimage4, Vimage5, AirConditioner, PowerDoorLocks, AntiLockBrakingSystem, BrakeAssist, PowerSteering, DriverAirbag, PassengerAirbag, PowerWindows, CDPlayer, CentralLocking, CrashSensor, LeatherSeats) VALUES(:vehtitle, :brand, :vehoverview, :priceperday, :fueltype, :modelyear, :seatingcapacity, :vimg1, :vimg2, :vimg3, :vimg4, :vimg5, :airconditioner, :powerdoorlocks, :antilockbrakingsys, :brakeassist, :powersteering, :driverairbag, :passengerairbag, :powerwindow, :cdplayer, :centrallocking, :crashcensor, :leatherseats)";

    $statement = $dbh->prepare($sql);
    $statement->bindParam(':vehtitle', $vTitle, PDO::PARAM_STR);
    $statement->bindParam(':brand', $brandName, PDO::PARAM_INT);
    $statement->bindParam(':vehoverview', $vehicleOverview, PDO::PARAM_STR);
    $statement->bindParam(':priceperday', $pricePerDay, PDO::PARAM_INT);
    $statement->bindParam(':fueltype', $fuealType, PDO::PARAM_INT);
    $statement->bindParam(':modelyear', $modelYear, PDO::PARAM_INT);
    $statement->bindParam(':seatingcapacity', $seatingCapacity, PDO::PARAM_INT);
    $statement->bindParam(':vimg1', $newfilenameOne);
    $statement->bindParam(':vimg2', $newfilenameTwo);
    $statement->bindParam(':vimg3', $newfilenameThree);
    $statement->bindParam(':vimg4', $newfilenameFour);
    $statement->bindParam(':vimg5', $newfilenameFive);

    $statement->bindParam(':airconditioner', $airConditioner);
    $statement->bindParam(':powerdoorlocks', $powerDoorLocks);
    $statement->bindParam(':antilockbrakingsys', $antiLockBrakingSystem);
    $statement->bindParam(':brakeassist', $brakeAssist);
    $statement->bindParam(':powersteering', $powerSteering);
    $statement->bindParam(':driverairbag', $driverAirbag);
    $statement->bindParam(':passengerairbag', $passengerAirbag);
    $statement->bindParam(':powerwindow', $powerWindows);
    $statement->bindParam(':cdplayer', $cdPlayer);
    $statement->bindParam(':centrallocking', $centralLocking);
    $statement->bindParam(':crashcensor', $crashSensor);
    $statement->bindParam(':leatherseats', $leatherSeats);

    $inserted = $statement->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId)
    {
        $output = json_encode(array(
            "message" => "Vehicle posted successfully.",
            "status" => true
        ));
    }
    else
    {
        $output = json_encode(array(
            "message" => "Some error ocurred while vehicle posting. Try again later!",
            "status" => false
        ));
    }

}
else
{
    $output = json_encode(array(
        "status" => false,
        "message" => "You are not allowed to access this page."
    ));
}

echo ($output);
?>