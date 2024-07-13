<?php
include "config.php";

$booking_id = $_GET['id'];
  // Check if the token is set in the session
  if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];

    // Retrieve the user's token from the database
    if(isset($_SESSION['customer_id'])){
      $customerID = $_SESSION['customer_id'];
      $checkTokenSql = "SELECT token FROM customer WHERE customer_id = '$customerID'";
      $checkTokenResult = mysqli_query($conn, $checkTokenSql);
      
      if ($checkTokenResult) {
          $row = mysqli_fetch_assoc($checkTokenResult);
          $dbToken = $row['token'];
  
          // Compare the session token with the token stored in the database
          if ($token === $dbToken) {
              // Token is valid, user is authenticated
              // Proceed with the page logic
			  

              }

          } else {
              // Token mismatch, invalid session
              // Redirect the user to the login page or perform any necessary action
              echo '<script>alert("Your session has expired. Please log in again.");</script>';
              echo "<script>window.location.href = 'logout.php';</script>";
          }
      } 
	  elseif(isset($_SESSION['user_id'])){
		$userID = $_SESSION['user_id'];
		$checkTokenSql = "SELECT token FROM user WHERE user_id = '$userID'";
		$checkTokenResult = mysqli_query($conn, $checkTokenSql);
		
		if ($checkTokenResult) {
			$row = mysqli_fetch_assoc($checkTokenResult);
			$dbToken = $row['token'];
	
			// Compare the session token with the token stored in the database
			if ($token === $dbToken) {
				// Token is valid, user is authenticated
				// Proceed with the page logic
  
				$sql = "SELECT customer_id FROM booking WHERE booking_id = '$booking_id'";
				$result = mysqli_query($conn,$sql);
				while($row=mysqli_fetch_assoc($result))
				{

					$customerID =	$row['customer_id']; 
				}

			}
		}
	}
    } 
?>
<!DOCTYPE html>

<html>
	<head>
		<title>PHP Print</title>
  		<link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script>
//   function printAndGoBack() {
//     window.print(); // Trigger print action
//     window.history.back(); // Go back to the previous page
//   }
// </script>
	</head>
	<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12"><br><br>
			<h1>DEWAN TUN ABDUL RAZAK COURT</h1>
			<h4>DTAR</h4>			
			<hr>
			<h2>Invoice</h2>
			<hr>
				<table class="table table-bordered print">
					<thead>
						<tr>
							<th>Num.</th>
							<th>Hall</th>
							<th>Court</th>
							<th>Date<br>Time</th>
							<th>Duration<br>(hours)</th>
							<th>Total Price</th>
						</tr>
					</thead>
					
					<tbody>
						<?php
							$sql1 = "	SELECT * FROM CUSTOMER WHERE customer_id = '$customerID' ";
											
							$result = mysqli_query($conn, $sql1);
          	
							while($row=mysqli_fetch_assoc($result))
							{

							?>
								<ol>
									<li><b>Username     : </b><?php echo $row['customer_name']; ?></li>
									<li><b>Email        : </b><?php echo $row['customer_email']; ?></li>
									<li><b>Phone Num.   : </b><?php echo $row['customer_phone']; ?></li>
									<li><b>Address      : </b><?php echo $row['customer_address']; ?></li>
								</ol>
							<?php
							}
		
								$sn=1;
								$sql = "SELECT * FROM booking_court BC 
										JOIN booking B 
										ON BC.booking_id = B.booking_id 
										JOIN court C 
										ON BC.court_id = C.court_id 
										JOIN hall H 
										ON H.hall_id = C.hall_id
										JOIN customer CS
										ON CS.customer_id = B.customer_id
										WHERE B.booking_id = '$booking_id'
										-- JOIN payment P
										-- ON P.booking_id = B.booking_id
										-- JOIN payment_method PM
										-- ON PM.paymentmethod_id = P.paymentmethod_id
										";
										$result = mysqli_query($conn, $sql);
							
										if (mysqli_num_rows($result) > 0) {
										$count = 1;
										while ($row = mysqli_fetch_assoc($result)) {
											
										//Date for court use time
										$booked = $row['booking_usedatetime'];
										$booked_usetime = DateTime::createFromFormat('Y-m-d H:i:s', $booked);
										$usedatetime = $booked_usetime->format('d/m/Y h:iA');
										$day = $booked_usetime->format('l'); // Retrieves the day
										$date = $booked_usetime->format('d/m/Y'); // Retrieves the date
										$time = $booked_usetime->format('h:i A'); // Retrieves the time
						
										//date when booking was made
										$booked2 = $row['booking_datetime'];
										$booked_made = DateTime::createFromFormat('Y-m-d H:i:s', $booked2);
										// $booked_made = $booked_made->format('d/m/Y h:iA');
										$day2 = $booked_made->format('l'); // Retrieves the day
										$date2 = $booked_made->format('d/m/Y'); // Retrieves the date
										$time2 = $booked_made->format('h:i A'); // Retrieves the time
						
										//break hall name
										$hall = $row['hall_name'];
										if($hall == "Dewan Kenangan Tun Abdul Razak")
										{
										$hall = "Dewan Kenangan Tun Abdul Razak";
										$parts = explode(" ", $hall);
						
										$first = $parts[0]." ".$parts[1];
										$second = $parts[2]." ".$parts[3]." ".$parts[4];
										}
					
										//find price
										$dayPrices = [
										'monday' => 10,
										'tuesday' => 10,
										'wednesday' => 10,
										'thursday' => 10,
										'friday' => 10,
										'saturday' => 12,
										'sunday' => 12
										];

									?>
									<tr>
										<td><?php echo $sn; ?></td>
										<td><?php echo (isset($first) ? $first . '<br>' . $second : $row['hall_name']); ?></td>
										<td><?php echo $row['court_num']; ?></td>
										<td><?php echo $date2 . '<br>' . $time2; ?></td>
										<td><?php echo $row['booking_duration']; ?></td>
										<td>RM <?php echo $price = $dayPrices[strtolower($day)] * $row['booking_duration']; ?></td>
									</tr>
								<?php
								$sn++;
									}
								}
								?>
					</tbody>
				</table>

				<div class="text-center"><br>
					<button onclick="window.print();" class="btn btn-primary" id="print-btn">Print your receipt</button>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>