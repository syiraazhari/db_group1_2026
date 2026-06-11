<?php
session_start();

// Gatekeeper: Ensure only someone logged in with a 'staff' role can see this page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') { //
    echo "<script>
            alert('Access Denied. Staff login required.');
            window.location='../register.php'; 
          </script>"; //
    exit(); //
} //

// Safely grab the logged-in staff member's name, fallback if not set
$staff_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Staff Member"; //

// Establish connection to database
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// --- 1. TELEMETRY: CARD DATA METRICS ---

// Metric A: Calculate Total Revenue (Sum of all non-cancelled/non-rejected reservation transactions)
// Assumes RentalPrice data is tracked through active vehicles linked over historical days or a cost metric.
// As a clean baseline metric, we count completed billing elements or calculate total active transaction scale:
$revenueResult = mysqli_query($conn, "SELECT SUM(v.RentalPrice * (DATEDIFF(r.ReturnDate, r.PickupDate) + 1)) AS TotalEarnings 
                                      FROM reservation r 
                                      JOIN vehicle v ON r.VehicleID = v.VehicleID 
                                      WHERE LOWER(r.ReservationStatus) NOT IN ('cancelled', 'rejected')");
$revenueRow = mysqli_fetch_assoc($revenueResult);
$totalEarnings = $revenueRow['TotalEarnings'] ? $revenueRow['TotalEarnings'] : 0.00;

// Metric B: Total Registered Customers
$customerCountResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM customer");
$customerRow = mysqli_fetch_assoc($customerCountResult);
$totalCustomers = $customerRow['total'];

// Metric C: Active Operational Fleet Units (Cars currently flagged as Available)
$fleetResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM vehicle WHERE LOWER(AvailabilityStatus) = 'available'");
$fleetRow = mysqli_fetch_assoc($fleetResult);
$availableCars = $fleetRow['total'];

// Metric D: Pending Booking Requests awaiting Staff approval/action
$pendingResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservation WHERE LOWER(ReservationStatus) = 'pending'");
$pendingRow = mysqli_fetch_assoc($pendingResult);
$pendingRequests = $pendingRow['total'];


// --- 2. LOG DATA: RECENT RESERVATIONS ACTION TABLE ---
$recentReservationsQuery = "SELECT r.ReservationID, r.CustomerID, v.VehicleName, r.PickupDate, r.ReturnDate, r.ReservationStatus 
                            FROM reservation r
                            JOIN vehicle v ON r.VehicleID = v.VehicleID
                            ORDER BY r.ReservationID DESC LIMIT 5";
$recentResult = mysqli_query($conn, $recentReservationsQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff Dashboard - Overview</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> 

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">CarBook Staff</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Interface</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Reservation</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reservation</h6>
                        <a class="collapse-item" href="records.php">Record</a>
                        <a class="collapse-item" href="history.php">History</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
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
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h5 class="mt-2 text-gray-600 font-weight-bold">Car Rental Management System</h5>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($staff_name); ?></span> <i class="fas fa-user-circle fa-lg text-gray-600"></i>
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
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Live Operations Dashboard</h1>
                        <span class="badge badge-primary p-2">Logged in as Staff</span>
                    </div>

                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Bookings Revenue</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RM <?php echo number_format($totalEarnings, 2); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Registered Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCustomers; ?> Users</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Fleet Cars Ready
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $availableCars; ?> Vehicles</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-car fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Action Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pendingRequests; ?> Requests</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-gradient-primary d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-stream mr-2"></i>Latest System Reservations Feed</h6>
                                    <a href="records.php" class="btn btn-sm btn-light text-primary font-weight-bold">View Full Bookings Board</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Customer ID</th>
                                                    <th>Assigned Vehicle</th>
                                                    <th>Pickup Date</th>
                                                    <th>Return Date</th>
                                                    <th>Status Label</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (mysqli_num_rows($recentResult) > 0) {
                                                    while($row = mysqli_fetch_assoc($recentResult)) {
                                                        $status = strtolower($row['ReservationStatus']);
                                                        
                                                        // Contextual Badge Colors
                                                        if ($status == 'pending') {
                                                            $badge = 'badge-warning';
                                                        } elseif (in_array($status, ['approved', 'active', 'confirmed'])) {
                                                            $badge = 'badge-success';
                                                        } elseif (in_array($status, ['ended', 'completed'])) {
                                                            $badge = 'badge-info';
                                                        } else {
                                                            $badge = 'badge-danger';
                                                        }
                                                        
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($row['ReservationID']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['CustomerID']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['VehicleName']) . "</td>";
                                                        echo "<td>" . date('Y-m-d', strtotime($row['PickupDate'])) . "</td>";
                                                        echo "<td>" . date('Y-m-d', strtotime($row['ReturnDate'])) . "</td>";
                                                        echo "<td><span class='badge " . $badge . " p-2 text-uppercase'>" . htmlspecialchars($row['ReservationStatus']) . "</span></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center text-muted py-4'>No recent reservations found in the tracking database.</td></tr>";
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
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CarBook Rental Management 2026</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5> <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button> <a class="btn btn-primary" href="../customer/logout.php">Logout</a> </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script> <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> <script src="vendor/jquery-easing/jquery.easing.min.js"></script> <script src="js/sb-admin-2.min.js"></script> </body>
</html>