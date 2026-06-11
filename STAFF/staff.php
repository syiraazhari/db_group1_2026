<?php
session_start();

// Gatekeeper: Ensure only logged-in staff can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    echo "<script>
            alert('Access Denied. Staff login required.');
            window.location='../register.php'; 
          </script>";
    exit();
}

$staff_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Staff Member";

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Handle adding a new staff record (Matching your exact columns: StaffName, Email, Password)
if (isset($_POST['add_staff'])) {
    $staffName = mysqli_real_escape_string($conn, $_POST['StaffName']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']); // Plain text or md5/password_hash depending on system design
    
    $insertQuery = "INSERT INTO staff (StaffName, Email, Password) VALUES ('$staffName', '$email', '$password')";
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: login.php?msg=success");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fixed Query: Only selecting valid columns present in your database structure snapshot
$query = "SELECT StaffID, StaffName, Email FROM staff ORDER BY StaffID ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff - Total Staff Records</title>

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

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="false" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Vehicle</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Vehicle Utilities:</h6>
                        <a class="collapse-item" href="vehicle_availability.php">Vehicle Availability</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Addons</div>

            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Staff</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Management:</h6>
                        <a class="collapse-item active" href="login.php">Total Staff</a>
                        <a class="collapse-item" href="register.php">Total Reservation</a>
                        <a class="collapse-item" href="forgot-password.php">Total Customer</a>
                        <a class="collapse-item" href="404.php">Total Vehicle</a>
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($staff_name); ?></span>
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
                        <h1 class="h3 mb-0 text-gray-800">Internal Staff Directory</h1>
                        <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#addStaffModal">
                            <i class="fas fa-user-plus fa-sm text-white-50 mr-1"></i> Register New Staff
                        </button>
                    </div>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> New employee profile saved inside database.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-gradient-primary">
                            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-users-cog mr-2"></i>Active Staff Roll Records</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Staff ID</th>
                                            <th>Staff Name</th>
                                            <th>Email Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['StaffID']) . "</td>";
                                                echo "<td><strong>" . htmlspecialchars($row['StaffName']) . "</strong></td>";
                                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No staff profiles found inside system data.</td></tr>";
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

    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="addStaffModalLabel"><i class="fas fa-user-shield mr-2"></i>Create New Staff Credentials</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="login.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Staff Full Name:</label>
                            <input type="text" name="StaffName" class="form-control" placeholder="e.g. Ahmad Dani" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email Address:</label>
                            <input type="email" name="Email" class="form-control" placeholder="e.g. ahmad@carbook.com" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">System Password:</label>
                            <input type="password" name="Password" class="form-control" placeholder="Enter secure account password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_staff" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Employee</button>
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
                    <a class="btn btn-primary" href="../customer/logout.php">Logout</a>
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