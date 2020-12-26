<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(0);


$typez = $_GET['tp'];


if($typez == "users"){
	$query = "SELECT * from tblusers";
}else if ($typez == "vehicals") {
	$query = "SELECT * from tblvehicles";
}else if ($typez == "booking") {
	$query = "SELECT * from tblbooking";
}else if ($typez == "brands") {
	$query = "SELECT id from tblbrands";
}else if ($typez == "subscribers") {
	$query = "SELECT * from tblsubscribers";
}else if ($typez == "contactusquery") {
	$query = "SELECT * from tblcontactusquery";
}else if ($typez == "testimonial") {
	$query = "SELECT * from tbltestimonial";
}


$allData = array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    $output = json_encode(array(
        "message" => "Data found.",
        "status" => true,
        "counts" => $total_row
    ));
    http_response_code(200);    
}
else
{
    $output = json_encode(array(
        "message" => "No data found",
        "status" => false,
        "counts" => 0
    ));
    http_response_code(200);
    
}
echo ($output);
?>