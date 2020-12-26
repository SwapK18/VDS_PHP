<?php
include ('includes/config.php');
require_once "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);

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
    $query = 'SELECT tblusers.FullName,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId 
    AS vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers ON tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.FkVehBrandId=tblbrands.id';

    // $query = 'SELECT tblusers.FullName,tblbrands.BrandName, tblvehicles.Vimage1, tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers on tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.FkVehBrandId=tblbrands.id WHERE 1';

    $allUsers = array();
    $statement = $dbh->prepare($query);
    $statement->execute();
    $total_row = $statement->rowCount();
    $output = '';

    if ($total_row > 0)
    {
        while ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {

            $allUsers[] = ($row);

        }
        // http_response_code(200);
        $output = json_encode(array(
            "message" => "Datas found.",
            "status" => true,
            "data" => $allUsers
        ));
        // $output = json_encode($allCars);
        
    }
    else
    {
        $output = json_encode(array(
            "message" => "No datas found",
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
