<?php
include("../config/db.php");

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // =================================================================
    // 1. DYNAMIC DATABASE STAFF CHECK (Using your exact SQL Columns)
    // =================================================================
    $staff_sql = "SELECT * FROM staff WHERE Username = '$username' AND Password = '$password'";
    $staff_result = mysqli_query($conn, $staff_sql);

    if (mysqli_num_rows($staff_result) == 1) {
        $row = mysqli_fetch_assoc($staff_result);
        
        session_regenerate_id(true); 
        
        // Saving session parameters mapped to your staff table columns
        $_SESSION['user_id']   = $row['StaffID']; 
        $_SESSION['username']  = $row['Username'];
        $_SESSION['user_name'] = $row['StaffName']; // Captures 'aizul iman' from the database
        $_SESSION['role']      = "staff"; 

        echo "<script>
                alert('Welcome back, " . $row['StaffName'] . " (Staff)!');
                window.location='../staff/index.php';
              </script>";
        exit();
    }

    // =================================================================
    // 2. REGULAR CUSTOMER CHECK
    // =================================================================
    $customer_sql = "SELECT * FROM customer WHERE Username = '$username' AND Password = '$password'";
    $customer_result = mysqli_query($conn, $customer_sql);

    if (mysqli_num_rows($customer_result) == 1) {
        $row = mysqli_fetch_assoc($customer_result);
        
        session_regenerate_id(true);
        $_SESSION['customer_id'] = $row['CustomerID'];
        $_SESSION['username']    = $row['Username'];
        $_SESSION['role']        = "customer"; 

        echo "<script>
                alert('Welcome back, " . $row['FullName'] . "!');
                window.location='../customer/index.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Invalid Username or Password!');
                window.history.back();
              </script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Portal</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                placeholder="Enter Username..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>