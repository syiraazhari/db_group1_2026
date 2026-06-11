<?php
// 1. DATABASE CONFIGURATION & CONNECTION
require_once '../config/db.php'; 

if (isset($_POST['submit_booking_action'])) {
    $customerID = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $vehicleID  = mysqli_real_escape_string($conn, $_POST['vehicle_id']);
    $todayDate  = date('Y-m-d H:i:s');
    
    // Process standard daily timestamp boundaries
    $pickupDate = mysqli_real_escape_string($conn, $_POST['pickup_date']) . ' 00:00:00';
    $returnDate = mysqli_real_escape_string($conn, $_POST['return_date']) . ' 23:59:59';
    
    // 2. CONCURRENCY CONTROLLER ENGINE: Verify calendar blocks
    $checkSQL = "SELECT * FROM reservation 
                 WHERE VehicleID = '$vehicleID' 
                 AND ReservationStatus != 'Cancelled'
                 AND (
                     ('$pickupDate' BETWEEN PickupDate AND ReturnDate) 
                     OR ('$returnDate' BETWEEN PickupDate AND ReturnDate)
                     OR (PickupDate BETWEEN '$pickupDate' AND '$returnDate')
                 )";
                 
    $checkResult = mysqli_query($conn, $checkSQL);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>
                alert('Vehicle Status Error: This vehicle is already reserved by another customer during your chosen dates.');
                window.location.href = 'rent.php';
              </script>";
        exit();
    } else {
        // 3. LOG NEW CONFIRMED ENTRIES
        $insertSQL = "INSERT INTO reservation (CustomerID, VehicleID, ReservationDate, PickupDate, ReturnDate, ReservationStatus) 
                      VALUES ('$customerID', '$vehicleID', '$todayDate', '$pickupDate', '$returnDate', 'Confirmed')";
                      
        if (mysqli_query($conn, $insertSQL)) {
            echo "<script>
                    alert('Success! Your reservation has been booked and logged into the database records.');
                    window.location.href = 'rent.php';
                  </script>";
            exit();
        } else {
            echo "SQL Matrix Exception Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: rent.php");
    exit();
}
?>