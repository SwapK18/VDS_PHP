<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


session_start();
error_reporting(1);
include('includes/config.php');

$userData = array();
$pagetype= $_REQUEST['type'];
$sql = "SELECT type,detail,PageName FROM tblpages WHERE type=:pagetype";



$query = $dbh->prepare($sql);
$query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
$query->execute();

// $results=$query->fetchAll(PDO::FETCH_OBJ);
// $cnt=1;
if($query->rowCount() > 0)
{
	while($row=$query->fetch(PDO::FETCH_ASSOC)){
  
      $userData[] = ($row);
 
	}
echo $json = json_encode($userData);
}
?>