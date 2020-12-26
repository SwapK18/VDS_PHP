<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(1);


$input = json_decode(file_get_contents('php://input'));
$eml = $_GET['eml'];

    $query = "SELECT FullName, EmailId, ContactNo, RegDate FROM tblusers WHERE  EmailId='".$eml."'";

$allInfo = array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {

        $allInfo[] = ($row);

    }
    // http_response_code(200);
    $output = json_encode(array(
        "message" => "Data found.",
        "status" => true,
        "data" => $allInfo
    ));
    // $output = json_encode($allCars);
    
}
else
{
    $output = json_encode(array(
        "message" => "Profile data not found. Try again later.",
        "status" => false
    ));
    // http_response_code(401);
    
}
echo ($output);
?>
