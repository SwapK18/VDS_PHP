<?php
include ('includes/config.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$input = json_decode(file_get_contents('php://input'));
$output = '';

$fname = $input->fullname;
$email = $input->emailid;
$mobile = $input->mobileno;
$password_hash = password_hash($input->password, PASSWORD_BCRYPT);

$sqlEmailCheck = "SELECT EmailId FROM tblusers WHERE EmailId = '" . $email . "'";
// $sqlEmailCheck = "SELECT email FROM admin WHERE email = '" . $email . "'";
$EmailCheck = $dbh->prepare($sqlEmailCheck);
$EmailCheck->execute();
$total_row = $EmailCheck->rowCount();

if ($total_row > 0)
{
    http_response_code(401);
    $output = json_encode(array(
        "message" => "Email is already there. Try something else.",
        "emailStatus" => true
    ));
}
else if ($total_row <= 0)
{

    $sql = "INSERT INTO  tblusers(FullName,EmailId,ContactNo,Password) VALUES(:fname,:email,:mobile,:password)";
    // $sql = "INSERT INTO  admin(UserName,Password,email) VALUES(:fname,:password,:email)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_INT);
    $query->bindParam(':password', $password_hash, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId)
    {
        http_response_code(200);
        $output = json_encode(array(
            "message" => "Data inserted successfully.",
            "status" => true
        ));
    }
    else
    {

        http_response_code(401);
        $output = json_encode(array(
            "message" => "Sorry! Error in data insertion.",
            "status" => false
        ));
    }
}
echo ($output);
?>
