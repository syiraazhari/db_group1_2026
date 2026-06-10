<?php
// ==========================================
// 1. DATABASE CONFIGURATION & CONNECTION
// ==========================================
$host    = "localhost";
$db_user = "root";       // Your phpMyAdmin username
$db_pass = "";           // Your phpMyAdmin password
$db_name = "car_rental_db"; // ⚠️ CHANGE THIS to your real database name!

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Fail gracefully if the database cannot connect
if (!$conn) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'>
            <h3>Database Connection Failure!</h3>
            <p><strong>Error Details:</strong> " . mysqli_connect_error() . "</p>
         </div>");
}

// ==========================================
// 2. FETCH RECORDS FROM YOUR CUSTOMERS TABLE
// ==========================================
// This query matches your exact columns: CustomerID, FullName, Email, PhoneNumber, Address, Username, Password
$query  = "SELECT CustomerID, FullName, Email, PhoneNumber, Address, Username FROM customer ORDER BY CustomerID DESC";
$result = mysqli_query($conn, $query);

// Check if the query is failing
if (!$result) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'>
            <h3>SQL Query Execution Failed!</h3>
            <p><strong>Error Details:</strong> " . mysqli_error($conn) . "</p>
         </div>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CarBook Administration - Customer Registry</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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

            <div class="sidebar-heading">Management</div>

            <li class="nav-item active">
                <a class="nav-link" href="customer_record.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Customer Records</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column" style="width: 100%;">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800" style="padding-left: 10px;">Customer Registration Directory</h1>
                </nav>
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registered Customers Matrix</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
<thead>
    <tr>
        <th>Customer ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Username</th>
        <th>Actions</th> </tr>
</thead>

<tbody>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['CustomerID']; ?></td>
        <td><?php echo $row['FullName']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['PhoneNumber']; ?></td>
        <td><?php echo $row['Address']; ?></td>
        <td><?php echo $row['Username']; ?></td>
        <td>
            <a href="edit_customer.php?id=<?php echo $row['CustomerID']; ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete_customer.php?id=<?php echo $row['CustomerID']; ?>" 
               class="btn btn-sm btn-danger" 
               onclick="return confirm('Are you sure?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
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
                        <span>Copyright &copy; CarBook System 2026</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../customer/login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

</body>
</html>