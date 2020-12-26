<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(1);

// $query = "SELECT UserEmail, Testimonial, PostingDate, status FROM tbltestimonial WHERE 1 ";

$query = "SELECT id,name,EmailId,ContactNumber,Message,PostingDate,status FROM tblcontactusquery";

$allQueries = array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    while ($row = $statement->fetchAll(PDO::FETCH_OBJ))
    {

        $allQueries = ($row);

    }
    http_response_code(200);
    $output = json_encode(array(
        "message" => "Queries found.",
        "status" => true,
        "data" => $allQueries
    ));
    
}
else
{
    $output = json_encode(array(
        "message" => "No users found",
        "status" => false
    ));
    http_response_code(401);

}
echo ($output);
?>
