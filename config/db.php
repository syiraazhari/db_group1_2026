<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "car_rental_db"
);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

?>