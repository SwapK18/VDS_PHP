<?php 
session_start();
include('includes/config.php');
error_reporting(1);

$lmt = (int)$_GET['limit'];

if(isset($lmt) && $lmt === 0){

	 $query = "SELECT tblbrands.BrandName,tblvehicles.Vimage1,tblvehicles.SeatingCapacity,tblvehicles.PricePerDay,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.VehiclesTitle,carrental.tblFuealType.typeName, carrental.tblFuealType.typeDesc FROM carrental.tblbrands INNER JOIN carrental.tblvehicles ON tblbrands.id = tblvehicles.FkVehBrandId INNER JOIN carrental.tblFuealType ON tblFuealType.id = tblvehicles.FkFuelTypeId WHERE 1 ";
	 
	 if(isset($_POST["brandz"]))
	 {
	  $brand_filter = implode(",", $_POST["brandz"]);
	  $query .= "AND tblbrands.id IN(".$brand_filter.")";
	 }
	 if(isset($_POST["typez"]))
	 {
	  $type_filter = implode(",", $_POST["typez"]);
	  $query .= "AND tblFuealType.id IN(".$type_filter.")";
	 }

}else if(isset($lmt) && $lmt > 0){
	$query = "SELECT tblbrands.BrandName,tblvehicles.Vimage1,tblvehicles.SeatingCapacity,tblvehicles.PricePerDay, tblvehicles.VehiclesOverview,tblvehicles.ModelYear,tblvehicles.id,tblvehicles.VehiclesTitle,carrental.tblFuealType.typeName, carrental.tblFuealType.typeDesc FROM carrental.tblbrands INNER JOIN carrental.tblvehicles ON tblbrands.id = tblvehicles.FkVehBrandId INNER JOIN carrental.tblFuealType ON tblFuealType.id = tblvehicles.FkFuelTypeId WHERE 1 LIMIT " . $lmt;
}
 
 $statement = $dbh->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();
 $output = '';

 
 if($total_row > 0)
 {
  foreach($result as $result)
  {
    $output .='
    <div class="product-listing-m gray-bg">
          <div class="product-listing-img"><img src="admin/img/vehicleimages/'. $result["Vimage1"] .'" class="img-responsive" alt="Image" /> </a> 
          </div>
          <div class="product-listing-content">
            <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">'. $result["BrandName"] . ' , '.$result["VehiclesTitle"] . '</a></h5>
            <p class="list-price">RS '. $result["PricePerDay"] .' </p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i>'. $result["SeatingCapacity"] . ' seats</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i>'. $result["ModelYear"] .' model</li>
              <li><i class="fa fa-car" aria-hidden="true"></i>'. $result["typeName"] .'</li>
            </ul>
            <a href="vehical-details.php?vhid='. $result["id"] .'" class="btn">Book <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
          </div>
        </div>
    ';
  }
 }
 else
 {
  $output = '<h4 class="text-center">No Data Found</h4>';
 }
 echo $output;
?>