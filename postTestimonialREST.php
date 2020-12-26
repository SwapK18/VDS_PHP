<?php
require_once ("./includes/config.php");
require_once "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(1);

function validateJWT()
{
    $key = "CARRENTAL";
    // $key = "CARRENTAL";
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
            $decoded = JWT::decode($jwt, $key, array('HS256'));

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
    $input = json_decode(file_get_contents("php://input"));

    $emailz = $input->email;
    $testimonoialz = $input->testimonial;
    $stats = 0;


    $sql = "INSERT INTO  tbltestimonial(UserEmail, Testimonial, status) VALUES(:email,:testimonoial,:stats)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $emailz, PDO::PARAM_STR);
    $query->bindParam(':testimonoial', $testimonoialz, PDO::PARAM_STR);
    $query->bindParam(':stats', $stats, PDO::PARAM_INT);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();


    if ($lastInsertId)
    {
        echo json_encode(array(
            "status" => true,
            "message" => "Testimonail submitted successfully."
        ));
    }
    else
    {
        echo json_encode(array(
            "status" => false,
            "message" => "Something went wrong. Please try again."
        ));
    }
}
else
{
    echo json_encode(array(
        "status" => false,
        "message" => "You are not allowed to access this page."
    ));
}
?>