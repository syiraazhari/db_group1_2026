<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['customer_id'])){
    header("Location:login.php");
}

if(isset($_POST['reserve'])){

    $customerID = $_SESSION['customer_id'];
    $vehicleID = $_POST['vehicle'];
    $pickup = $_POST['pickup'];
    $return = $_POST['return'];

    $sql = "INSERT INTO reservation
    (CustomerID, VehicleID, ReservationDate, PickupDate, ReturnDate, ReservationStatus)
    VALUES
    ('$customerID','$vehicleID',CURDATE(),'$pickup','$return','Pending')";

    mysqli_query($conn,$sql);

    echo "Reservation Submitted!";
}
?>

<form method="POST">

<h2>Reserve Vehicle</h2>

<select name="vehicle">

<?php
$result = mysqli_query($conn,"SELECT * FROM vehicle");

while($row = mysqli_fetch_assoc($result)){
?>

<option value="<?php echo $row['VehicleID']; ?>">
<?php echo $row['VehicleName']; ?>
</option>

<?php } ?>

</select>

<br><br>

Pickup Date:
<input type="date" name="pickup"><br><br>

Return Date:
<input type="date" name="return"><br><br>

<button type="submit" name="reserve">Reserve</button>

</form>