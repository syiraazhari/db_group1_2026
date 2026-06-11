<?php
// Establish connection to your database
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Handle ending the reservation
if (isset($_GET['action']) && $_GET['action'] == 'end' && isset($_GET['id'])) {
    $reservationID = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Update the status to 'Ended' (or 'Completed' depending on your preference)
    $updateQuery = "UPDATE reservation SET ReservationStatus = 'Ended' WHERE ReservationID = '$reservationID'";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Refresh the page to show updated status
        header("Location: records.php");
        exit();
    } else {
        echo "<script>alert('Error updating reservation: " . mysqli_error($conn) . "');</script>";
    }
}

// Select directly from the reservation table exactly as structured
$query = "SELECT ReservationID, CustomerID, VehicleID, StaffID, ReservationDate, PickupDate, ReturnDate, ReservationStatus FROM reservation ORDER BY ReservationID DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff - Active Reservations</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">CarBook Staff</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Interface</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Reservation</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reservation</h6>
                        <a class="collapse-item active" href="records.php">Record</a>
                        <a class="collapse-item" href="history.php">History</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Vehicle</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Vehicle</h6>
                        <a class="collapse-item" href="vehicle_availability.php">Vehicle Availability</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Addons</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Staff</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Management:</h6>
                        <a class="collapse-item" href="staff.php">Total Staff</a>
                        <a class="collapse-item" href="reservationlist.php">Total Reservation</a>
                        <a class="collapse-item" href="customerlist.php">Total Customer</a>
                        <a class="collapse-item" href="vehiclelist.php">Total Vehicle</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="customer_record.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Customer</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h5 class="mt-2 text-gray-600">Car Rental Management System</h5>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Staff Account</span>
                                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Current System Reservations</h1>
                    </div>

                    <!-- Reservation Data Table Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary">
                            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-table mr-2"></i>Live Master Booking Logs</h6>
                        </div>
                        <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
            <tr>
                <th>ReservationID</th>
                <th>CustomerID</th>
                <th>VehicleID</th>
                <th>StaffID</th>
                <th>ReservationDate</th>
                <th>PickupDate</th>
                <th>ReturnDate</th>
                <th>ReservationStatus</th>
                <th class="text-center">Action</th> <!-- Added Action Header -->
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // Set status color styles
                    $statusClass = "badge-warning";
                    $statusClean = strtolower($row['ReservationStatus']);
                    
                    if($statusClean == 'approved' || $statusClean == 'confirmed') $statusClass = "badge-success";
                    if($statusClean == 'cancelled' || $statusClean == 'rejected' || $statusClean == 'ended') $statusClass = "badge-danger";
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ReservationID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['CustomerID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['VehicleID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['StaffID']) . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['ReservationDate'])) . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['PickupDate'])) . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['ReturnDate'])) . "</td>";
                    echo "<td><span class='badge " . $statusClass . " p-2 text-uppercase'>" . htmlspecialchars($row['ReservationStatus']) . "</span></td>";
                    
                    // Action button column logic
                    echo "<td class='text-center'>";
                    if ($statusClean != 'ended' && $statusClean != 'cancelled' && $statusClean != 'rejected') {
                        echo "<a href='records.php?action=end&id=" . $row['ReservationID'] . "' 
                                 class='btn btn-danger btn-sm' 
                                 onclick='return confirm(\"Are you sure you want to end this reservation?\");'>
                                 <i class='fas fa-hourglass-end mr-1'></i> End Rental
                              </a>";
                    } else {
                        echo "<span class='text-muted small'><i class='fas fa-check-circle'></i> Closed</span>";
                    }
                    echo "</td>";
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center py-4 text-muted'>No entries found in reservation database.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CarBook Rental 2026</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>