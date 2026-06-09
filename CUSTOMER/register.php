<?php
include("../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO customer
    (FullName, Email, PhoneNumber, Address, Username, Password)
    VALUES
    ('$fullname','$email','$phone','$address','$username','$password')";

    mysqli_query($conn, $sql);

    echo "<script>alert('Registration Successful!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Customer Register</title>

    <!-- FIXED PATHS (VERY IMPORTANT) -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

<div class="row justify-content-center">

<div class="col-xl-10 col-lg-12 col-md-9">

<div class="card o-hidden border-0 shadow-lg my-5">

<div class="card-body p-0">

<div class="row">

<!-- IMAGE SIDE -->
<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

<!-- FORM SIDE -->
<div class="col-lg-7">

<div class="p-5">

<div class="text-center">
<h1 class="h4 text-gray-900 mb-4">Customer Registration</h1>
</div>

<form class="user" method="POST">

<div class="form-group">
<input type="text" name="fullname"
class="form-control form-control-user"
placeholder="Full Name" required>
</div>

<div class="form-group">
<input type="email" name="email"
class="form-control form-control-user"
placeholder="Email Address" required>
</div>

<div class="form-group">
<input type="text" name="phone"
class="form-control form-control-user"
placeholder="Phone Number">
</div>

<div class="form-group">
<input type="text" name="address"
class="form-control form-control-user"
placeholder="Address">
</div>

<div class="form-group">
<input type="text" name="username"
class="form-control form-control-user"
placeholder="Username" required>
</div>

<div class="form-group">
<input type="password" name="password"
class="form-control form-control-user"
placeholder="Password" required>
</div>

<button type="submit" name="register"
class="btn btn-primary btn-user btn-block">

Register Account

</button>

</form>

<hr>

<div class="text-center">
<a href="login.php">Already have an account? Login</a>
</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<!-- FIXED JS PATHS (VERY IMPORTANT) -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>

</body>
</html>