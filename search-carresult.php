<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AHNA | CAR Rental</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <link href="assets/css/slick.css" rel="stylesheet">
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="background-color:aqua;">

<?php include('includes/header.php');?>

<div class="page-heading text-center">
  <br/><br/>
  <h1 style="color:blue;">CAR LISTING</h1>
</div>

<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper" style="background-color:black;">
          <div class="sorting-count" style="color:blue;">
<?php
$brand = $_REQUEST['brand'] ?? '';
$fueltype = $_REQUEST['fueltype'] ?? '';

if ($brand && $fueltype) {
  $sql = "SELECT id FROM tblvehicles WHERE VehiclesBrand=:brand AND FuelType=:fueltype";
  $query = $dbh->prepare($sql);
  $query->bindParam(':brand', $brand, PDO::PARAM_STR);
  $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = $query->rowCount();
  echo "<p style='color:blue;'><center><span>$cnt CARS</span></center></p>";
} else {
  echo "<p style='color:red;'><center><span>Invalid Search Parameters</span></center></p>";
}
?>
          </div>
        </div>

<?php
if ($brand && $fueltype && $cnt > 0) {
  $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
          JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
          WHERE tblvehicles.VehiclesBrand=:brand AND tblvehicles.FuelType=:fueltype";
  $query = $dbh->prepare($sql);
  $query->bindParam(':brand', $brand, PDO::PARAM_STR);
  $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  foreach ($results as $result) {
?>
  <div class="product-listing-m gray-bg">
    <div class="product-listing-img">
      <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image" />
    </div>
    <div class="product-listing-content">
      <h5>
        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
          <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?>
        </a>
      </h5>
      <p class="list-price">$<?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
      <ul>
        <li><i class="fa fa-user"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
        <li><i class="fa fa-calendar"></i> <?php echo htmlentities($result->ModelYear); ?> model</li>
        <li><i class="fa fa-car"></i> <?php echo htmlentities($result->FuelType); ?></li>
      </ul>
      <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn" style="background-color:blue;">View Details</a>
    </div>
  </div>
<?php
  }
}
?>

      </div>

      <!-- Sidebar -->
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget" style="background-color:black;">
          <div class="widget_heading">
            <h5 style="color:blue;">Find Your Car</h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option>Select Brand</option>
                  <?php 
                    $sql = "SELECT * FROM tblbrands";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach ($results as $result) {
                        echo '<option value="'.$result->id.'">'.htmlentities($result->BrandName).'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option>Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block" style="background-color:blue;">SEARCH</button>
              </div>
            </form>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php include('includes/footer.php');?>
<?php include('includes/login.php');?>
<?php include('includes/registration.php');?>
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
