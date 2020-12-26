<?php
include ('includes/config.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$input = json_decode(file_get_contents('php://input'));
$output = '';

$email = $input->emailid;

$sqlEmailCheck = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$EmailCheck = $dbh->prepare($sqlEmailCheck);
$EmailCheck-> bindParam(':subscriberemail', $email, PDO::PARAM_STR);
$EmailCheck->execute();
$total_row = $EmailCheck->rowCount();

if ($total_row > 0)
{
    $output = json_encode(array(
        "message" => "Email is already subscribed. Try something else.",
        "emailStatus" => true
    ));
}
else if ($total_row <= 0)
{

    $sql = "INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':subscriberemail', $email, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId)
    {
        http_response_code(200);
        $output = json_encode(array(
            "message" => "Email subscribed successfully.",
            "emailStatus" => true
        ));
    }
    else
    {

        http_response_code(401);
        $output = json_encode(array(
            "message" => "Sorry! Error in email subscribtion.",
            "emailStatus" => false
        ));
    }
}
echo ($output);
?>
