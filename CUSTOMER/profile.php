<?php
// 1. DATABASE CONFIGURATION & CONNECTION
require_once '../config/db.php'; 

// NO SECURITY OR LOGIN CHECK - ANYONE CAN VIEW THIS PAGE

// Set a fixed CustomerID to load data without a login session
$customerID = 1; 
$message = "";

// 2. UPDATE LOGIC: If form is submitted, update the database record
if (isset($_POST['update_profile'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['FullName']);
    $email    = mysqli_real_escape_string($conn, $_POST['Email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
    $address  = mysqli_real_escape_string($conn, $_POST['Address']);

    $sql = "UPDATE customer SET FullName='$fullName', Email='$email', PhoneNumber='$phone', Address='$address' WHERE CustomerID='$customerID'";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success' style='border-radius: 5px; margin-bottom: 20px;'>Your profile info has been updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger' style='border-radius: 5px; margin-bottom: 20px;'>Error updating profile: " . mysqli_error($conn) . "</div>";
    }
}

// 3. FETCH CURRENT DATA: Pre-fill the form with existing user info
$query = "SELECT * FROM customer WHERE CustomerID = '$customerID'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Customer Profile View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">Faw<span>Car</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
	          <li class="nav-item"><a href="pricing.php" class="nav-link">Pricing</a></li>
	          <li class="nav-item"><a href="car.php" class="nav-link">Cars</a></li>
	          <li class="nav-item active"><a href="contact.php" class="nav-link">Customer Profile</a></li>
			              <li class="nav-item"><a href="logout.php" class="nav-link" onclick="return confirm('Are you sure you want to log out?');" style="color: #ff4d4d; font-weight: bold;">Logout</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Profile <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Profile Dashboard</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section">
      <div class="container">
        <div class="row d-flex mb-5 justify-content-center">
          
          <div class="col-md-8 block-9 mb-md-5">
            <h2 class="mb-4 text-center" style="font-weight: 600;">Customer Details Matrix</h2>
            
            <?php echo $message; ?>

            <form method="POST" action="contact.php" class="bg-light p-5 contact-form" style="border-radius: 10px; box-shadow: 0px 0px 15px rgba(0,0,0,0.05);">
              
              <div class="form-group">
                <label style="font-weight: bold; color: #555;">Full Name</label>
                <input type="text" name="FullName" class="form-control" value="<?php echo htmlspecialchars($row['FullName'] ?? ''); ?>" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #555;">Email Address</label>
                <input type="email" name="Email" class="form-control" value="<?php echo htmlspecialchars($row['Email'] ?? ''); ?>" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #555;">Phone Number</label>
                <input type="text" name="PhoneNumber" class="form-control" value="<?php echo htmlspecialchars($row['PhoneNumber'] ?? ''); ?>" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #555;">Residential Address</label>
                <textarea name="Address" cols="30" rows="4" class="form-control" required><?php echo htmlspecialchars($row['Address'] ?? ''); ?></textarea>
              </div>

              <div class="form-group text-center mt-4">
                <input type="submit" name="update_profile" value="Update Customer Profile" class="btn btn-primary py-3 px-5" style="border-radius: 5px;">
              </div>

            </form>
          </div>

        </div>
      </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | CarBook System 2026</p>
          </div>
        </div>
      </div>
    </footer>
    
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>