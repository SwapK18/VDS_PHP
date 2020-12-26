<?php
include ('includes/config.php');
require_once "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);
function validateJWT()
{
    $key = "ADMINCARRENTAL";
    // get posted data
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

    $arr = explode(" ", $authHeader);

    // get jwt
    // $jwt = isset($temp_header[1]) ? $temp_header[1] : "";
    $jwt = $arr[1];

    if ($jwt)
    {

        // if decode succeed, show user details
        try
        {
            // decode jwt
            // $decoded = JWT::decode($jwt, $key, array('HS256'));
            $decoded = JWT::decode($jwt, $key, array(
                'HS256'
            ));

            // show user details
            return true;
        }

        // if decode fails, it means jwt is invalid
        catch(Exception $e)
        {
            // tell the user access denied  & show error message
            return false;
        }
    }

    // show error message if jwt is empty
    else
    {
        // tell the user access denied
        return false;
    }
}

$allowUserAccess = validateJWT();

if ($allowUserAccess === true)
{
    $input = json_decode(file_get_contents('php://input'));
    $typez = $input->type;
    $delId = $input->idz;

    // Brand delete
    if ($typez == 'subscriber')
    {
        $sql = "DELETE FROM tblsubscribers WHERE id = '" . $delId . "'";
    }

    if ($typez == 'Brand')
    {
        $sql = "DELETE FROM tblbrands WHERE id = '" . $delId . "'";
    }

    // vehical delete
    if ($typez == 'Vehical')
    {
        $sql = "DELETE FROM tblvehicles WHERE id = '" . $delId . "'";
    }

    $query = $dbh->prepare($sql);
    $lastInsertId = $dbh->lastInsertId();

    if ($query->execute())
    {
        $output = json_encode(array(
            "message" => "Record deleted successfully",
            "status" => true
        ));
        http_response_code(200);
    }
    else
    {
        $output = json_encode(array(
            "message" => "Record deletion failed",
            "status" => false
        ));
    }
}
else
{
    $output = json_encode(array(
        "status" => false,
        "message" => "You are not allowed to access this page."
    ));
}
echo ($output);
?>