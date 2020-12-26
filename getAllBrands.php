<?php
error_reporting(0);
include('includes/config.php');

$assocDataArray = array();
$query = "SELECT  id, BrandName, checked, UpdationDate, CreationDate FROM tblbrands";
	$statement = $dbh->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';

if($total_row > 0)
{
	echo $output;
}
?>