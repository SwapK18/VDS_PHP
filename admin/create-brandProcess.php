
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
// Code for change password	
if(isset($_POST['submit']))
{
	$brandz=$_POST['brand'];

	// echo "<script>alert(".$brandz.")</script>";
	$chkParam = false;
	$sql="INSERT INTO tblbrands(BrandName) VALUES(:brand)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':brand',$brandz, PDO::PARAM_STR);
	// $query->bindParam(':chkd', true, PDO::PARAM_INT);
	$query->execute();

	$lastInsertId = $dbh->lastInsertId();
	if($query->execute())
	{
		$msg = "Brand Created successfully";
	}
	else 
	{
		$error = "Something went wrong. Please try again";
	}

	echo($msg);
	echo($error);
}
}
?>