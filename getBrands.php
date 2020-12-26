<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(0);
include('includes/config.php');

$input = json_decode(file_get_contents('php://input'));
$brandidz = $input->brndId;


	$assocDataArray = array();
	if(isset($brandidz)){
		$query = "SELECT  id, BrandName, isChecked, UpdationDate, CreationDate FROM tblbrands WHERE id='".$brandidz."'";
	}else if(! isset($brandidz)){
		$query = "SELECT  id, BrandName, isChecked, UpdationDate, CreationDate FROM tblbrands WHERE 1";
	}
	$statement = $dbh->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';

if($total_row > 0)
{
	foreach($result as $res){
		$id =  (int)$res["id"];
		$BrandName  =  $res["BrandName"];
		$UpdationDate  =  $res["UpdationDate"];
		$CreationDate  =  $res["CreationDate"];
		$checked =  $res["isChecked"] ? true : false;
		
		$assocDataArray[] = ["id" => $id ,"BrandName" => $BrandName, "isChecked" => $checked, "UpdationDate" => $UpdationDate, "CreationDate" => $CreationDate];
	}
	echo $json = json_encode($assocDataArray);	
}

?>