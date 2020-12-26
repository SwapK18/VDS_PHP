<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(0);


$folderPath = "../assets/images/";
$input = json_decode(file_get_contents('php://input'));
$recId = $_POST['vehRecId'];
$file_namesOne = isset($_FILES["imageOne"]["name"]) ? $_FILES["imageOne"]["name"] : null;


    $image_infoOne = explode(".", $file_namesOne);
    $image_typeOne = end($image_infoOne);
    $original_file_nameOne = pathinfo($file_namesOne, PATHINFO_FILENAME);
    $file_urlOne = $original_file_nameOne . "-" . date("YmdHis") . "." . $image_typeOne;
    move_uploaded_file($_FILES["imageOne"]["tmp_name"][0], $folderPath . $file_urlOne);

    $sql="UPDATE tblvehicles SET Vimage1=:imgz1 WHERE id=:idz";
    $query = $dbh->prepare($sql);
    $query->bindParam(':imgz1',$file_urlOne,PDO::PARAM_STR);
    $query->bindParam(':idz',$recId,PDO::PARAM_STR);

if($query->execute())
{
    $output = json_encode(array(
        "message" => "Data updated",
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