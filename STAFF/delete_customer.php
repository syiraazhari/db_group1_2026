<?php
require_once 'customer_record.php'; // Reuse your connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM customer WHERE CustomerID = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Record Deleted'); window.location='customer_record.php';</script>";
    }
}
?>