<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
include('includes/config.php');
error_reporting(0);

$input = json_decode(file_get_contents('php://input'));
$output = '';
$email=$input->emailid;

$sqlEmailCheck="SELECT EmailId FROM tblusers WHERE EmailId = '".$email."'";
$EmailCheck = $dbh->prepare($sqlEmailCheck);
$EmailCheck->execute();
$total_row = $EmailCheck->rowCount();

if($total_row > 0)
{
    $output = json_encode(
        array(
            "status" => true
    ));
}else{
    $output = json_encode(
        array(
            "status" => false
    ));
}
echo($output);
?>