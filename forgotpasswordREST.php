<?php
include ('includes/config.php');
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
error_reporting(0);

$input = json_decode(file_get_contents("php://input"));

$emailid = $input->emailid;
$mobileno = $input->mobileno;
$password = password_hash($input->password, PASSWORD_BCRYPT);


$table_name = 'tblusers ';

$query = "SELECT id, ContactNo, EmailId, Password, FullName FROM " . $table_name . "  WHERE EmailId=:email";

$query = $dbh->prepare($query);
$query->bindParam(':email', $emailid, PDO::PARAM_STR);
$query->execute();
$num = $query->rowCount();


if ($num > 0)
{
    
        $queryUpdt = "UPDATE tblusers SET Password=:pass WHERE EmailId=:eml AND ContactNo=:mobile";


        $queryUpdt = $dbh->prepare($queryUpdt);
        $queryUpdt->bindParam(':eml', $emailid, PDO::PARAM_STR);
        $queryUpdt->bindParam(':pass', $password, PDO::PARAM_STR);
        $queryUpdt->bindParam(':mobile', $mobileno, PDO::PARAM_STR);
        $queryUpdt->execute();
     
        echo json_encode(array(
            "status" => true,
            "message" => "Your new password has been set successfully"
        ));
   
}else{
    echo json_encode(array(
            "status" => false,
            "message" => "There may be problem in email. Try another email."
        ));
}
?>