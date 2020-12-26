<?php
include ('includes/config.php');
require_once "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);

$useremail = $_GET['email'];

if(isset($useremail)){
    $query = 'SELECT tblusers.FullName,tblbrands.BrandName, tblvehicles.Vimage1, tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers on tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.FkVehBrandId=tblbrands.id WHERE tblbooking.userEmail=:useremail';
}else{
    $query = 'SELECT tblusers.FullName,tblbrands.BrandName, tblvehicles.Vimage1, tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  FROM tblbooking JOIN tblvehicles ON tblvehicles.id=tblbooking.VehicleId JOIN tblusers on tblusers.EmailId=tblbooking.userEmail JOIN tblbrands ON tblvehicles.FkVehBrandId=tblbrands.id WHERE 1';
}

    $allUsers = array();
    $statement = $dbh->prepare($query);
    $statement->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $statement->execute();
    $total_row = $statement->rowCount();
    $output = '';

    if ($total_row > 0)
    {
        while ($row = $statement->fetchAll(PDO::FETCH_OBJ))
        {

            $allUsers = ($row);

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

echo ($output);
?>
