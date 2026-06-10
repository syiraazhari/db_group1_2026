<?php
// 1. Establish connection (ensure this file points to your actual config)
$conn = mysqli_connect("localhost", "root", "", "car_rental_db");

// 2. Check if an ID is present
if (!isset($_GET['id'])) {
    die("No Customer ID provided!");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. Handle the Update Submission
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['FullName']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $phone = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
    $addr  = mysqli_real_escape_string($conn, $_POST['Address']);

    // THE SQL UPDATE COMMAND
    $sql = "UPDATE customer SET FullName='$name', Email='$email', PhoneNumber='$phone', Address='$addr' WHERE CustomerID='$id'";
    
    if (mysqli_query($conn, $sql)) {
        // Success: Redirect back to the main list
        header("Location: customer_record.php?status=success");
        exit();
    } else {
        // If this prints, you have a spelling error in your column names!
        die("Database Error: " . mysqli_error($conn));
    }
}

// 4. Fetch the existing data to fill the form
$query = "SELECT * FROM customer WHERE CustomerID = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Customer not found.");
}
?>

<form method="POST" action="edit_customer.php?id=<?php echo $id; ?>">
    <input type="text" name="FullName" value="<?php echo htmlspecialchars($data['FullName']); ?>" required>
    <input type="email" name="Email" value="<?php echo htmlspecialchars($data['Email']); ?>" required>
    <input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($data['PhoneNumber']); ?>" required>
    <input type="text" name="Address" value="<?php echo htmlspecialchars($data['Address']); ?>" required>
    
    <button type="submit" name="update">Update Record</button>
</form>