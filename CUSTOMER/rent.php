<?php
// 1. DATABASE CONFIGURATION & CONNECTION
require_once '../config/db.php';

// Default mock customer context id matching system structure
$customerID = 1; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rental Car Listing</title>
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

    <style>
      /* Cosmetic Disabled Button Styles */
      .btn-disabled-cosmetic a {
          background: #e6e6e6 !important;
          border: 1px solid #d9d9d9 !important;
          color: #8c8c8c !important;
          cursor: not-allowed !important;
          pointer-events: none; /* Stops clicks completely */
      }
    </style>
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
	          <li class="nav-item"><a href="availabality.php" class="nav-link">Availabality</a></li>
	          <li class="nav-item active"><a href="rent.php" class="nav-link">Rent</a></li>
	          <li class="nav-item"><a href="car.php" class="nav-link">Cars</a></li>
	          <li class="nav-item"><a href="profile.php" class="nav-link">Customer Profile</a></li>
			  <li class="nav-item"><a href="logout.php" class="nav-link" onclick="return confirm('Are you sure you want to log out?');" style="color: #ff4d4d; font-weight: bold;">Logout</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Pricing <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Pricing</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="car-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th class="bg-primary heading">Per Hour Rate</th>
						        <th class="bg-dark heading">Per Day Rate</th>
						        <th class="bg-black heading">Leasing</th>
						      </tr>
						    </thead>
						    <tbody>
						      
						      <!-- ROW 1: Perodua Aruz -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/aruz.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Perodua Aruz</h3>
						        	<p class="mb-0 rated">
    									<span>rated:</span>
 										<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
									    <span class="ion-ios-star"></span>
									    <span class="ion-ios-star" style="color: #e6e6e6;"></span>
									</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
						        	</div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="1" data-name="Perodua Aruz" data-price="45.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 45.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
						        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 2: Honda City Hatchback -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/city_hatchback.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Honda City Hatchback</h3>
						        	<p class="mb-0 rated">
    									<span>rated:</span>
    									<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
    									<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="2" data-name="Honda City Hatchback" data-price="50.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 50.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 3: Honda Civic -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/civic.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Honda Civic</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="3" data-name="Honda Civic" data-price="70.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 70.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 4: Honda CRV -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/crv.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Honda CRV</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star" style="color: #e6e6e6;"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="4" data-name="Honda CRV" data-price="65.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 65.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 5: Proton Emas 7 -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/emas7.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Proton Emas 7</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star" style="color: #e6e6e6;"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="5" data-name="Proton Emas 7" data-price="56.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 56.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 6: Toyota Yaris GR -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/yaris_gr.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Toyota Yaris GR</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="6" data-name="Toyota Yaris GR" data-price="75.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 75.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 7: Honda HRV -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/hrv.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Honda HRV</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star" style="color: #e6e6e6;"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="7" data-name="Honda HRV" data-price="50.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 50.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 8: Perodua Myvi -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/myvi.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Perodua Myvi</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="8" data-name="Perodua Myvi" data-price="35.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 35.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						      <!-- ROW 9: Proton S70 -->
						      <tr class="text-center">
						      	<td class="car-image"><div class="img" style="background-image:url(images/s70.jpg);"></div></td>
						        <td class="product-name text-left">
						        	<h3>Proton S70</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/hr</span></h3>
							        </div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#" class="rent-trigger-btn" data-id="9" data-name="Proton S70" data-price="45.00">Rent a car</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num">RM 45.00</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        </div>
						        </td>

						        <td class="price">
						        	<p class="btn-custom btn-disabled-cosmetic"><a href="#">Not Available</a></p>
						        	<div class="price-rate">
							        	<h3><span class="num">—</span><span class="per">/mo</span></h3>
							        </div>
						        </td>
						      </tr><!-- END TR-->

						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
		</section>

    <!-- POP-UP MODAL FRAMEWORK -->
    <div class="modal fade" id="rentDateSelectionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-header bg-dark text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title" style="font-weight: 600; font-family: 'Poppins', sans-serif;">Confirm Vehicle Schedule</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="process_rent.php" method="POST">
                    <div class="modal-body p-4" style="font-family: 'Poppins', sans-serif;">
                        <input type="hidden" name="vehicle_id" id="sysVehicleID">
                        <input type="hidden" name="customer_id" value="<?php echo $customerID; ?>">

                        <div class="p-3 mb-4 rounded border bg-light" style="font-size: 14px;">
                            <div class="mb-1"><strong>Selected Model:</strong> <span id="lblCarName" class="text-dark"></span></div>
                            <div class="mb-1"><strong>Rental Tier:</strong> <span class="badge badge-primary px-2 py-1">Per Day Rate</span></div>
                            <div><strong>Rate Fee Breakdown:</strong> <span class="font-weight-bold">RM <span id="lblPrice"></span></span></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="font-weight-bold text-dark small">Pick-up Date</label>
                                <input type="date" name="pickup_date" id="calPickup" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group col-6">
                                <label class="font-weight-bold text-dark small">Return Date</label>
                                <input type="date" name="return_date" id="calReturn" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit_booking_action" class="btn btn-primary px-4">Verify Availability</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footers -->
    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | CarBook System</p>
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

    <script>
    $(document).ready(function() {
        $('.rent-trigger-btn').on('click', function(e) {
            e.preventDefault();
            
            var carId = $(this).data('id');
            var carName = $(this).data('name');
            var price = $(this).data('price');

            $('#sysVehicleID').val(carId);
            $('#lblCarName').text(carName);
            $('#lblPrice').text(price);

            $('#rentDateSelectionModal').modal('show');
        });

        $('#calPickup').on('change', function() {
            $('#calReturn').attr('min', $(this).val());
        });
    });
    </script>
  </body>
</html>