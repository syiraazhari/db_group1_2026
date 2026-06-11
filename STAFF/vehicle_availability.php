<?php
// Establish connection to your database
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// 1. Handle New Vehicle Insertion Form Submission
if (isset($_POST['add_vehicle'])) {
    $vehicleName = mysqli_real_escape_string($conn, $_POST['VehicleName']);
    $vehicleType = mysqli_real_escape_string($conn, $_POST['VehicleType']);
    $plateNumber = mysqli_real_escape_string($conn, $_POST['PlateNumber']);
    $rentalPrice = mysqli_real_escape_string($conn, $_POST['RentalPrice']);
    $status = mysqli_real_escape_string($conn, $_POST['AvailabilityStatus']);
    
    $insertQuery = "INSERT INTO vehicle (VehicleName, VehicleType, PlateNumber, RentalPrice, AvailabilityStatus) 
                    VALUES ('$vehicleName', '$vehicleType', '$plateNumber', '$rentalPrice', '$status')";
    
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: vehicle_availability.php?msg=added");
        exit();
    } else {
        echo "<script>alert('Error adding vehicle: " . mysqli_error($conn) . "');</script>";
    }
}

// 2. Handle Status Toggling (Available <=> Not Available)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $vehicleID = mysqli_real_escape_string($conn, $_GET['id']);
    $currentStatus = mysqli_real_escape_string($conn, $_GET['status']);
    
    // Determine the opposite target status
    $newStatus = (strtolower($currentStatus) == 'available') ? 'Not Available' : 'Available';
    
    $updateQuery = "UPDATE vehicle SET AvailabilityStatus = '$newStatus' WHERE VehicleID = '$vehicleID'";
    
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: vehicle_availability.php");
        exit();
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch all rows from the vehicle fleet catalog table using exact column names
$query = "SELECT VehicleID, VehicleName, VehicleType, PlateNumber, RentalPrice, AvailabilityStatus FROM vehicle ORDER BY VehicleID ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff - Vehicle Status Management</title>

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

            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Interface</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Reservation</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reservation:</h6>
                        <a class="collapse-item" href="records.php">Record</a>
                        <a class="collapse-item" href="history.php">History</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Vehicle</span>
                </a>
                <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Vehicle Utilities:</h6>
                        <a class="collapse-item active" href="vehicle_availability.php">Vehicle Availability</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Addons</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
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
                    <h5 class="mt-2 text-gray-600">Car Rental Management System</h5>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
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
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Fleet Availability Status</h1>
                        <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#addVehicleModal">
                            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add New Vehicle
                        </button>
                    </div>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> New vehicle has been registered to the system fleet successfully.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary">
                            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-car mr-2"></i>Live Vehicle Fleet Logs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Vehicle ID</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Type</th>
                                            <th>Plate Number</th>
                                            <th>Rental Price</th>
                                            <th>Availability Status</th>
                                            <th class="text-center">Manage Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $statusClean = strtolower($row['AvailabilityStatus']);
                                                
                                                if ($statusClean == 'available') {
                                                    $badgeClass = "badge-success";
                                                    $btnClass = "btn-warning";
                                                    $btnIcon = "fa-toggle-off";
                                                    $btnText = "Mark Unavailable";
                                                } else {
                                                    $badgeClass = "badge-danger";
                                                    $btnClass = "btn-success";
                                                    $btnIcon = "fa-toggle-on";
                                                    $btnText = "Mark Available";
                                                }
                                                
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['VehicleID']) . "</td>";
                                                echo "<td><strong>" . htmlspecialchars($row['VehicleName']) . "</strong></td>";
                                                echo "<td>" . htmlspecialchars($row['VehicleType']) . "</td>";
                                                echo "<td><span class='badge badge-secondary py-1 px-2'>" . htmlspecialchars($row['PlateNumber']) . "</span></td>";
                                                echo "<td class='text-primary font-weight-bold'>RM " . number_format($row['RentalPrice'], 2) . "/day</td>";
                                                echo "<td><span class='badge " . $badgeClass . " p-2 text-uppercase'>" . htmlspecialchars($row['AvailabilityStatus']) . "</span></td>";
                                                
                                                // Dynamic Toggle Action Link Button
                                                echo "<td class='text-center'>";
                                                echo "<a href='vehicle_availability.php?action=toggle&id=" . $row['VehicleID'] . "&status=" . urlencode($row['AvailabilityStatus']) . "' 
                                                         class='btn " . $btnClass . " btn-sm font-weight-bold'
                                                         onclick='return confirm(\"Change status for " . htmlspecialchars($row['VehicleName']) . "?\");'>
                                                         <i class='fas " . $btnIcon . " mr-1'></i> " . $btnText . "
                                                      </a>";
                                                echo "</td>";
                                                
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center py-4 text-muted'>No vehicles registered inside the fleet system database.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CarBook Rental 2026</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="addVehicleModalLabel"><i class="fas fa-plus-circle mr-2"></i>Register New Fleet Vehicle</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="vehicle_availability.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Vehicle Name / Model:</label>
                            <input type="text" name="VehicleName" class="form-control" placeholder="e.g. Perodua Myvi" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Vehicle Type:</label>
                            <select name="VehicleType" class="form-control" required>
                                <option value="">-- Select Type --</option>
                                <option value="SUV">SUV</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Sedan">Sedan</option>
                                <option value="MPV">MPV</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Plate Number:</label>
                            <input type="text" name="PlateNumber" class="form-control" placeholder="e.g. WMM 5135" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Rental Price (RM per Day):</label>
                            <input type="number" step="0.01" name="RentalPrice" class="form-control" placeholder="e.g. 45.00" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Initial Availability Status:</label>
                            <select name="AvailabilityStatus" class="form-control" required>
                                <option value="Available">Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_vehicle" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>