<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('includes/config.php');
error_reporting(1);

$lmt = $_GET['limit'];

$input = json_decode(file_get_contents('php://input'));

if ($lmt == 0)
{

    $query = "SELECT tblbrands.BrandName,tblvehicles.Vimage1,tblvehicles.SeatingCapacity,tblvehicles.PricePerDay,tblvehicles.VehiclesOverview, tblvehicles.ModelYear,tblvehicles.id,tblvehicles.VehiclesTitle,carrental.tblFuealType.typeName, carrental.tblFuealType.typeDesc FROM carrental.tblbrands INNER JOIN carrental.tblvehicles ON tblbrands.id = tblvehicles.FkVehBrandId INNER JOIN carrental.tblFuealType ON tblFuealType.id = tblvehicles.FkFuelTypeId WHERE 1 ";

    if (!empty($input->brandz))
    {
        $brand_filter = implode("','", $input->brandz);
        $query .= " AND tblbrands.BrandName IN('" . $brand_filter . "')";
    }
    if (!empty($input->typez))
    {
        $type_filter = implode("','", $input->typez);
        $query .= " AND tblFuealType.typeName IN('" . $type_filter . "')";
    }
}
else if (isset($lmt) && $lmt > 0)
{
    $query = "SELECT tblbrands.BrandName,tblvehicles.Vimage1,tblvehicles.SeatingCapacity,tblvehicles.PricePerDay,tblvehicles.VehiclesOverview,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.VehiclesTitle,carrental.tblFuealType.typeName, carrental.tblFuealType.typeDesc FROM carrental.tblbrands INNER JOIN carrental.tblvehicles ON tblbrands.id = tblvehicles.FkVehBrandId INNER JOIN carrental.tblFuealType ON tblFuealType.id = tblvehicles.FkFuelTypeId LIMIT " . $lmt;
}

$allCars = array();
$statement = $dbh->prepare($query);
$statement->execute();
$total_row = $statement->rowCount();
$output = '';

if ($total_row > 0)
{
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {

        $allCars[] = ($row);

    }
    // http_response_code(200);
    $output = json_encode(array(
        "message" => "Data found.",
        "status" => true,
        "data" => $allCars
    ));
    // $output = json_encode($allCars);
    
}
else
{
    $output = json_encode(array(
        "message" => "No data found",
        "status" => false
    ));
    // http_response_code(401);
    
}
echo ($output);
?>