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