<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(0);

$input = json_decode(file_get_contents('php://input'));
$brandz = $input->brndName;
$brandIdz = (int)$input->brndId;

$sql = "UPDATE tblbrands SET BrandName='" . $brandz . "' WHERE id='" . $brandIdz . "'";
$query = $dbh->prepare($sql);

if ($query->execute())
{
    $output = json_encode(array(
        "message" => "Data Inserted",
        "status" => true,
        "lastInserID" => $lastInsertId
    ));
    http_response_code(200);
}
else
{
    $output = json_encode(array(
        "message" => "Insertion failed",
        "status" => false,
        "lastInserID" => null
    ));
    http_response_code(401);

}
echo ($output);
?>
