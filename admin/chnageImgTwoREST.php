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

    $file_nameTwosTwo = isset($_FILES["imageTwo"]["name"]) ? $_FILES["imageTwo"]["name"] : null;

if(isset($file_nameTwosTwo)){
    $extTwo = explode(".",  $file_nameTwosTwo);
    $newfilenameTwo = $extTwo[0] .  "-"  . date("His") . '.' . end($extTwo);
    move_uploaded_file($_FILES["imageTwo"]["tmp_name"],  $folderPath . $newfilenameTwo);
}

    $sql="UPDATE tblvehicles SET Vimage2=:imgz2 WHERE id=:idz";
    $query = $dbh->prepare($sql);
    $query->bindParam(':imgz2',$newfilenameTwo,PDO::PARAM_STR);
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
?>1