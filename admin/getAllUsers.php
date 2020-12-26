<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(1);


    $query = "SELECT EmailId, ContactNo, FullName, RegDate, UpdationDate FROM tblusers WHERE 1 ";


$allUsers = array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {

        $allUsers[] = ($row);

    }
    // http_response_code(200);
    $output = json_encode(array(
        "message" => "Users found.",
        "status" => true,
        "data" => $allUsers
    ));
    // $output = json_encode($allCars);
    
}
else
{
    $output = json_encode(array(
        "message" => "No users found",
        "status" => false
    ));
}
echo ($output);
?>
