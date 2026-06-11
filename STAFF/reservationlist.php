<?php
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Fetch all records without filtering by state metrics
$query = "SELECT ReservationID, CustomerID, VehicleID, StaffID, ReservationDate, PickupDate, ReturnDate, ReservationStatus FROM reservation ORDER BY ReservationID DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Master Analytics - Booking Matrix</title>
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
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages"><i class="fas fa-fw fa-folder"></i><span>Reservations List</span></a>
                <div id="collapsePages" class="collapse show">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="login.php">Total Staff</a>
                        <a class="collapse-item active" href="register.php">Total Reservation</a>
                        <a class="collapse-item" href="forgot-password.php">Total Customer</a>
                        <a class="collapse-item" href="404.php">Total Vehicle</a>
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
                    <div class="mb-4"><h1 class="h3 mb-0 text-gray-800">Master Fleet Reservation Registry</h1></div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary"><h6 class="m-0 font-weight-bold text-white"><i class="fas fa-list-alt mr-2"></i>Global Database Audit Flow Logs</h6></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Reservation ID</th>
                                            <th>Customer ID</th>
                                            <th>Vehicle ID</th>
                                            <th>Staff ID</th>
                                            <th>Reservation Date</th>
                                            <th>Pickup Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $status = strtolower($row['ReservationStatus']);
                                                $badge = 'badge-warning';
                                                if($status == 'approved' || $status == 'confirmed') $badge = 'badge-success';
                                                if($status == 'ended' || $status == 'completed') $badge = 'badge-info';
                                                if($status == 'cancelled' || $status == 'rejected') $badge = 'badge-danger';

                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['ReservationID']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['CustomerID']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['VehicleID']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['StaffID'] ? $row['StaffID'] : 'None') . "</td>";
                                                echo "<td>" . date('Y-m-d', strtotime($row['ReservationDate'])) . "</td>";
                                                echo "<td>" . date('Y-m-d', strtotime($row['PickupDate'])) . "</td>";
                                                echo "<td>" . date('Y-m-d', strtotime($row['ReturnDate'])) . "</td>";
                                                echo "<td><span class='badge " . $badge . " p-2 text-uppercase'>" . htmlspecialchars($row['ReservationStatus']) . "</span></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center text-muted'>No entries registered inside database ledger.</td></tr>";
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