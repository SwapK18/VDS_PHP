<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


session_start();
error_reporting(1);
include('includes/config.php');
	$assocDataArray = array();
	$query = "SELECT * FROM tblFuealType";
	$statement = $dbh->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';

// $results=$query->fetchAll(PDO::FETCH_OBJ);
// $cnt=1;
if($total_row > 0)
{
	foreach($result as $res){
		$id =  (int)$res["id"];
		$typeName  =  $res["typeName"];
		$typeDesc  =  $res["typeDesc"];
		$checked =  $res["isChecked"] ? true : false;
		
		$assocDataArray[] = [ "id" => $id ,"typeName" => $typeName , "typeDesc" => $typeDesc, "isChecked" => $checked ];
	}
	echo $json = json_encode($assocDataArray);
}
?>