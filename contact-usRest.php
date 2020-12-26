<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('includes/config.php');
error_reporting(1);


$sql  =  "INSERT INTO  tblcontactusquery(name,EmailId,ContactNumber,Message) VALUES(:name,:email,:contactno,:message)";

$input = json_decode(file_get_contents('php://input'));
$namee  =  $input->fullname;
$emaill  =  $input->email;
$contactnoo  =  $input->contactno;
$messagee  =  $input->message;

$query = $dbh->prepare($sql);
$query->bindParam(':name',$namee,PDO::PARAM_STR);
$query->bindParam(':email',$emaill,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactnoo,PDO::PARAM_STR);
$query->bindParam(':message',$messagee,PDO::PARAM_STR);
$query->execute();  
$lastInsertId = $dbh->lastInsertId();
$output = '';

if($lastInsertId)
{
    $output = json_encode(
        array(
            "message" => "Query Sent. We will contact you shortly.",
            "status" => true
    ));
}
else 
{
    $output = json_encode(
        array(
            "message" => "Something went wrong. Please try again.",
            "status" => false
    ));
}
echo($output);
?>