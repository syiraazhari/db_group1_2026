<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "vehicle_rental"
);

if(!$conn){
    die("Connection Failed");
}

?>