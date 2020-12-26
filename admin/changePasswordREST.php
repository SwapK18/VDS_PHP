<?php
require_once ("./includes/config.php");
require_once "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(0);

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
    $input = json_decode(file_get_contents("php://input"));

    $emailz = $input->admEmail;
    $oldpassword = $input->oldpassword;
    $newpassword = password_hash($input->newpassword, PASSWORD_BCRYPT);

    $table_name = 'admin ';

    $query = "SELECT * FROM " . $table_name . "  WHERE email=:emailz";
    $query = $dbh->prepare($query);
    $query->bindParam(':emailz', $emailz, PDO::PARAM_STR);
    $query->execute();
    $num = $query->rowCount();

    if ($num > 0)
    {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $emailzId = $row['email'];
        $password2 = $row['Password'];

        if (password_verify($oldpassword, $password2))
        {
            $queryUpdt = "UPDATE " . $table_name . " SET Password = :passnew WHERE email=:eml";
            $queryUpdt = $dbh->prepare($queryUpdt);
            $queryUpdt->bindParam(':eml', $emailzId, PDO::PARAM_STR);
            $queryUpdt->bindParam(':passnew', $newpassword, PDO::PARAM_STR);
            $queryUpdt->execute();
            $num = $queryUpdt->rowCount();

            date_default_timezone_set('Asia/Kolkata');
            $secret_key = "ADMINCARRENTAL";
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 3600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "email" => $emailzId
                )
            );

            http_response_code(200);
            $jwt = JWT::encode($token, $secret_key);
            echo json_encode(array(
                "status" => true,
                "message" => "Your new password has been set successfully.",
                "accessToken" => $jwt,
                "expireAt" => $expire_claim,
                "user" => array(
                    "email" => $emailzId
                )
            ));
        }
        else
        {

            echo json_encode(array(
                "status" => false,
                "message" => "There is problem in matching old password. Try again."
            ));
        }
    }
    else
    {
        echo json_encode(array(
            "status" => false,
            "message" => "There is problem in email. Try again."
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
