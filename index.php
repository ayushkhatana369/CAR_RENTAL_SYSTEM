<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<html>
<head>
  <title>AHNA | CAR Rental</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <link href="assets/css/slick.css" rel="stylesheet">
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
</head>

<body style="background-color:black;">

<?php include('includes/header.php');?>

<section id="banner">
  <img src="admin/img/vehicleimages/banner-image.jpg" style="width:100%;">
  <div class="container">
    <div class="text-block">
      <h4 style="color:white;">DRIVE IN A SANITISED CAR</h4><br/><br/>
    </div>
    <div class="text-blockk">
      <!-- ✅ Replaced simple link with working search form -->
      <form action="search-carresult.php" method="post">
        <div class="form-group">
          <select name="brand" class="form-control" required>
            <option value="">Select Brand</option>
            <?php 
              $sql = "SELECT * FROM tblbrands";
              $query = $dbh->prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              foreach($results as $result) {
                  echo '<option value="'.$result->id.'">'.htmlentities($result->BrandName).'</option>';
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <select name="fueltype" class="form-control" required>
            <option value="">Select Fuel Type</option>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
          </select>
        </div>
        <button type="submit" class="btn" style="background-color:blue;">Search Cars</button>
      </form>
    </div>
  </div>
</section>

<!-- Rest of your content (Self Drive Cars, Fun Facts, Footer, Scripts) -->
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
