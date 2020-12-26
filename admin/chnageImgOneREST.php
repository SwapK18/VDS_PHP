<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(0);

$folderPath = "../assets/images/";
$recId = $_POST['vehRecId'];

    $file_nameOnesOne = isset($_FILES["imageOne"]["name"]) ? $_FILES["imageOne"]["name"] : null;

if(isset($file_nameOnesOne)){
    $extOne = explode(".",  $file_nameOnesOne);
    $newfilenameOne = $extOne[0] .  "-"  . date("His") . '.' . end($extOne);
    move_uploaded_file($_FILES["imageOne"]["tmp_name"],  $folderPath . $newfilenameOne);
}

    $sql="UPDATE tblvehicles SET Vimage1=:imgz1 WHERE id=:idz";
    $query = $dbh->prepare($sql);
    $query->bindParam(':imgz1',$newfilenameOne,PDO::PARAM_STR);
    $query->bindParam(':idz',$recId,PDO::PARAM_STR);

if($query->execute())
{
    $output = json_encode(array(
        "message" => "Data updated successfully",
        "status" => true
    ));
    http_response_code(200);    
}
else
{
    $output = json_encode(array(
        "message" => "Updation failed",
        "status" => false
    ));
    http_response_code(401);
    
}
echo ($output);
?>