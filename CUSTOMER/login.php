<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer
    WHERE Username='$username'
    AND Password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['customer_id'] = $row['CustomerID'];

        header("Location:index.php");
    } else {
        echo "Invalid Login";
    }
}
?>

<form method="POST">

<h2>Login</h2>

<input type="text" name="username" placeholder="Username"><br><br>

<input type="password" name="password" placeholder="Password"><br><br>

<button type="submit" name="login">Login</button>

</form>