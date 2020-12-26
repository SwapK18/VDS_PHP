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

$query = "SELECT EmailId,Password FROM " . $table_name . "  WHERE EmailId=:email";

$query = $dbh->prepare($query);
$query->bindParam(':email', $emailid, PDO::PARAM_STR);
$query->execute();
$num = $query->rowCount();

if ($num > 0)
{
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $FullName = $row['FullName'];
    $EmailId = $row['EmailId'];
    $password2 = $row['Password'];

    if (password_verify($oldpassword, $password2))
    {
        $queryUpdt="update tblusers set Password=:pass where EmailId=:email and ContactNo=:mobile";
        $queryUpdt = $dbh->prepare($queryUpdt);
        $queryUpdt->bindParam(':eml', $emailid, PDO::PARAM_STR);
        $queryUpdt->bindParam(':pass', $password, PDO::PARAM_STR);
        $queryUpdt->bindParam(':mobile', $mobileno, PDO::PARAM_STR);
        $queryUpdt->execute();
        $num = $queryUpdt->rowCount();

        echo json_encode(array(
            "status" => true,
            "message" => "Your new password has been set successfully"
        ));
    }else{

        echo json_encode(array(
            "status" => false,
            "message" => "There is problem in matching current password. Try again."
        ));
    }
}else{
    echo json_encode(array(
            "status" => false,
            "message" => "There may be problem in email. Try another email."
        ));
}
?>