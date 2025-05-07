||||


|||||





|||||||
    $todate = $_POST['todate'];
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0;
    $vhid = $_GET['vhid'];

    $sql = "INSERT INTO tblbooking(userEmail, VehicleId, FromDate, ToDate, message, Status) 
            VALUES (:useremail, :vhid, :fromdate, :todate, :message, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Booking successful.');</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Details | Car Rental</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <style>
        body {
            background-color: black;
            font-family: 'Lato', sans-serif;
        }
        div {
            font-size: 20px;
            color: blue;
        }
        h2, h5, p, td, th {
            color: blue;
        }
        .listing_detail_wrap {
            background-color: aqua;
        }
        .main_features ul li {
            background-color: aqua;
            margin: 10px;
            padding: 10px;
            display: inline-block;
            width: 30%;
        }
        .sidebar_widget {
            background-color: aqua;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<?php
$vhid = intval($_GET['vhid']);
$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid 
        FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.id = :vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brndid'] = $result->bid;
?>

<!-- Vehicle Images -->
<section id="listing_img_slider">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <?php $image = "Vimage$i"; if (!empty($result->$image)): ?>
            <div>
                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->$image); ?>" width="100%" height="400" class="img-responsive">
            </div>
        <?php endif; ?>
    <?php endfor; ?>
</section>

<!-- Vehicle Detail -->
<section class="listing-detail">
    <div class="container">
        <div class="row listing_detail_head">
            <div class="col-md-9">
                <h2 style="color:aqua;"><?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?></h2>
            </div>
            <div class="col-md-3">
                <div class="price_info" style="color:aqua;">
                    <p style="color:blue;">₹<?php echo htmlentities($result->PricePerDay); ?></p>Per Day Rental
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left -->
            <div class="col-md-9">
                <div class="main_features">
                    <ul>
                        <li><i class="fa fa-calendar"></i>
                            <h5><?php echo htmlentities($result->ModelYear); ?></h5><p>Reg.Year</p></li>
                        <li><i class="fa fa-cogs"></i>
                            <h5><?php echo htmlentities($result->FuelType); ?></h5><p>Fuel Type</p></li>
                        <li><i class="fa fa-user-plus"></i>
                            <h5><?php echo htmlentities($result->SeatingCapacity); ?></h5><p>Seats</p></li>
                    </ul>
                </div>

                <div class="listing_more_info">
                    <div class="listing_detail_wrap">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#vehicle-overview" data-toggle="tab">Vehicle Overview</a></li>
                            <li role="presentation"><a href="#accessories" data-toggle="tab">Accessories</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                                <p><?php echo htmlentities($result->VehiclesOverview); ?></p>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="accessories">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr><th colspan="2">Accessories</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $accessories = [
                                            "AirConditioner" => "Air Conditioner",
                                            "AntiLockBrakingSystem" => "AntiLock Braking System",
                                            "PowerSteering" => "Power Steering",
                                            "PowerWindows" => "Power Windows",
                                            "CDPlayer" => "CD Player",
                                            "LeatherSeats" => "Leather Seats",
                                            "CentralLocking" => "Central Locking",
                                            "PowerDoorLocks" => "Power Door Locks",
                                            "BrakeAssist" => "Brake Assist",
                                            "DriverAirbag" => "Driver Airbag",
                                            "PassengerAirbag" => "Passenger Airbag",
                                            "CrashSensor" => "Crash Sensor"
                                        ];

                                        foreach ($accessories as $field => $label) {
                                            echo "<tr><td>$label</td><td>";
                                            echo ($result->$field) ? "<i class='fa fa-check'></i>" : "<i class='fa fa-close'></i>";
                                            echo "</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right / Sidebar -->
            <aside class="col-md-3">
                <div class="sidebar_widget">
                    <h5>Book Now</h5>
                    <form method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="fromdate" placeholder="Date From (DD/MM/YYYY)" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="todate" placeholder="Date To (DD/MM/YYYY)" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="3" placeholder="Extra Requirements..." required></textarea>
                        </div>
                        <?php if ($_SESSION['login']) { ?>
                            <input type="submit" class="btn btn-primary" name="submit" value="Book Now">
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-warning">Login To Book</a>
                        <?php } ?>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php
    }
}
?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
