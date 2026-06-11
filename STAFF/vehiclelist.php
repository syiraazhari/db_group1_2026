<?php
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Select query using target layout mapping
$query = "SELECT VehicleID, VehicleName, VehicleType, PlateNumber, RentalPrice, AvailabilityStatus FROM vehicle ORDER BY VehicleID ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Master Catalog - Fleet Assets</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-car"></i></div>
                <div class="sidebar-brand-text mx-3">CarBook Staff</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Management Options</div>
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages"><i class="fas fa-fw fa-folder"></i><span>Vehicle LogisticsCenter</span></a>
                <div id="collapsePages" class="collapse show">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="login.php">Total Staff</a>
                        <a class="collapse-item" href="register.php">Total Reservation</a>
                        <a class="collapse-item" href="forgot-password.php">Total Customer</a>
                        <a class="collapse-item active" href="404.php">Total Vehicle</a>
                    </div>
                </div>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h5 class="mt-2 text-gray-600 font-weight-bold">Car Rental Management System</h5>
                </nav>

                <div class="container-fluid">
                    <div class="mb-4"><h1 class="h3 mb-0 text-gray-800">Master Fleet Vehicle Inventory Assets</h1></div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary"><h6 class="m-0 font-weight-bold text-white"><i class="fas fa-car-side mr-2"></i>Registered System Garage Inventory Log</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Vehicle ID</th>
                                            <th>Vehicle Model Name</th>
                                            <th>Vehicle Type</th>
                                            <th>License Plate Number</th>
                                            <th>Daily Rental Charge Price</th>
                                            <th>Availability Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $status = strtolower($row['AvailabilityStatus']);
                                                $badge = ($status == 'available') ? 'badge-success' : 'badge-danger';
                                                
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['VehicleID']) . "</td>";
                                                echo "<td><strong>" . htmlspecialchars($row['VehicleName']) . "</strong></td>";
                                                echo "<td>" . htmlspecialchars($row['VehicleType']) . "</td>";
                                                echo "<td><span class='badge badge-secondary py-1 px-2'>" . htmlspecialchars($row['PlateNumber']) . "</span></td>";
                                                echo "<td class='text-primary font-weight-bold'>RM " . number_format($row['RentalPrice'], 2) . "/day</td>";
                                                echo "<td><span class='badge " . $badge . " p-2 text-uppercase'>" . htmlspecialchars($row['AvailabilityStatus']) . "</span></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center text-muted'>No automotive vehicles found in fleet files.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>