<?php
require "config.php";

$court_id = $_SESSION['selectedCourt'];
// echo $court_id;

// echo $_SESSION['selectedCourt'];
if (isset($_SESSION['token'])) {
  $token = $_SESSION['token'];

  // Retrieve the user's token from the database
  if($_SESSION['customer_id']){
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


  
              if (!isset($_SESSION['bookings'])) {
                $_SESSION['bookings'] = array();
              }
        
        
              $duration = 60;
              $cleanup = 0;
              $start = "09:00";
              $end = "24:00";
        
              function timeslots($duration, $cleanup, $start, $end) {
                  $start = new DateTime($start);
                  $end = new DateTime($end);
                  $interval = new DateInterval("PT" . $duration . "M");
                  $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
                  $slots = array();
        
                  for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
                      $endPeriod = clone $intStart;
                      $endPeriod->add($interval);
                    
                      if ($endPeriod > $end) {
                          break;
                      }
                    
                      $slots[] = $intStart->format("h:iA");
                  }
                
                  return $slots;
              } 
        
              function timeslots2($duration, $cleanup, $start, $end) {
                $start = new DateTime($start);
                $end = new DateTime($end);
                $interval = new DateInterval("PT" . $duration . "M");
                $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
                $slots = array();
        
                for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
                    $endPeriod = clone $intStart;
                    $endPeriod->add($interval);
                  
                    if ($endPeriod > $end) {
                        break;
                    }
                  
                    $slots[] = $intStart->format("H:iA");
                }
        
                return $slots;
              } 
        
              $sql = "SELECT * FROM booking JOIN booking_court 
              ON booking.booking_id = booking_court.booking_id 
              WHERE court_id = '$court_id'";
              $result = mysqli_query($conn, $sql);
              
              $bookedSlots = array(); // Initialize the array outside the while loop
              
              if ($result) {
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $courtId = $row['court_id'];
                    $booked = $row['booking_usedatetime'];
                    $bookedDuration = $row['booking_duration'];
                    $bookedDatetime = DateTime::createFromFormat('Y-m-d H:i:s', $booked);
              
                    if ($bookedDatetime) {
                      // If the duration is more than 1 hour, mark subsequent hour(s) as booked
                      if ($bookedDuration > 1) {
                        $formattedCurrentHour = $bookedDatetime;
                        $bookedSlots[$courtId][] = $formattedCurrentHour->format('d/m/Y h:iA');
                        $nextHour = clone $bookedDatetime;
              
                        for ($i = 1; $i < $bookedDuration; $i++) {
                          $nextHour->modify('+1 hour');
                          $formattedNextHour = $nextHour->format('d/m/Y h:iA');
                          $bookedSlots[$courtId][] = $formattedNextHour; // Mark subsequent hour(s) as booked
                        }
                      } else {
                        // Convert the stored datetime to the desired format
                        $formattedDatetime = $bookedDatetime->format('d/m/Y h:iA');
                        $bookedSlots[$courtId][] = $formattedDatetime; // Store the formatted datetime in the array
                      }
                    } else {
                      echo 'Invalid datetime format<br>';
                    }
                  }
                }
              }
  
              $bookings = array();

              if (isset($_POST['submit'])) {
                $history = "Pending";
                
                if (isset($_POST['duration'])) {
                  $duration = $_POST['duration'];
                }
              
                if (isset($_POST['duration_hidden']) && $_POST['duration_hidden'] == 1) {
                  $duration = $_POST['duration_hidden'];
                }
              
                $booking_usedatetime = $_POST['timeslot'];
                $booking_datetime = DateTime::createFromFormat('d/m/Y H:iA', $booking_usedatetime);
                $booking_usedatetime = $booking_datetime->format('Y-m-d H:i:s');
              
                // Insert data into the booking table
                $stmt = $conn->prepare("INSERT INTO booking(booking_usedatetime, booking_duration, booking_history, customer_id, booking_datetime, create_at) VALUES (?,?,?,?, NOW(), NOW())");
                $stmt->bind_param('sisi', $booking_usedatetime, $duration, $history, $customerID);
                $stmt->execute();
                
                // Retrieve the auto-generated ID value of the last inserted row
                $booking_id = $conn->insert_id;
              
                // Insert data into the booking_court table using the fetched booking_id and court_id
                $stmt2 = $conn->prepare("INSERT INTO booking_court(court_id, booking_id, token, create_at) VALUES (?,?,?,NOW())");
                $stmt2->bind_param('iis', $court_id, $booking_id, $token);
                $stmt2->execute();
              
                $bookings = $_SESSION['bookings'];
                $bookings[] = $booking_usedatetime;
                $_SESSION['bookings'] = $bookings;
              
                $stmt->close();
                $conn->close();
              
                echo "<script>alert('Booked successful!');</script>";
                echo "<script>alert('Please proceed with payment to complete your booking');</script>";
                echo "<script>window.location.href = 'book.php';</script>";
              }
        } else {
            // Token mismatch, invalid session
            // Redirect the user to the login page or perform any necessary action
            echo "<script>window.location.href = 'logout.php';</script>";
        }
    } else {
        // Failed to retrieve the token from the database
        // Redirect the user to the login page or perform any necessary action
        echo "<script>window.location.href = 'logout.php';</script>";
    }
  }
  else if($_SESSION['user_id']){
    $userID = $_SESSION['userr_id'];
    $checkTokenSql = "SELECT token FROM user WHERE user_id = '$userID'";
    $checkTokenResult = mysqli_query($conn, $checkTokenSql);
    
    if ($checkTokenResult) {
        $row = mysqli_fetch_assoc($checkTokenResult);
        $dbToken = $row['token'];

        // Compare the session token with the token stored in the database
        if ($token === $dbToken) {
            // Token is valid, user is authenticated
            // Proceed with the page logic
        } else {
            // Token mismatch, invalid session
            // Redirect the user to the login page or perform any necessary action
            echo "<script>window.location.href = 'logout.php';</script>";
        }
    } else {
        // Failed to retrieve the token from the database
        // Redirect the user to the login page or perform any necessary action
        echo "<script>window.location.href = 'logout.php';</script>";
    }
  }
  
} else {
  // Token not set in the session, user is not authenticated
  // Redirect the user to the login page or perform any necessary action
  echo "<script>window.location.href = 'logout.php';</script>";
}
      


    

?>
   

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/BadmintonWebsite/styles.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
  <title>Booking Page</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <style type="text/css">
    p, body, td, input, select, button { font-family: -apple-system,system-ui,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif; font-size: 14px; }
    body { padding: 0px; margin: 0px; background-color: #ffffff; }
    a { color: #1155a3; }
    .space { margin: 10px 0px 10px 0px; }
    .header { background: #003267; background: linear-gradient(to right, #011329 0%,#00639e 44%,#011329 100%); padding:20px 10px; color: white; box-shadow: 0px 0px 10px 5px rgba(0,0,0,0.75); }
    .header a { color: white; }
    .header h1 a { text-decoration: none; }
    .header h1 { padding: 0px; margin: 0px; }
    .main { padding: 10px; }
  </style>

</head>
<body class="bg-dtarblue w-full h-full relative">
  <!-- Navigation -->
  <nav class="py-1 text-dtarblue bg-white">
    <div class=" mx-auto flex items-center justify-between px-5 md:px-20">
    <img src="/BadmintonWebsite/assets/logo.png" class="w-24 h-auto" alt="">

      <ul class="flex flex-row space-x-4 font-bold text-xl">
        <li><a href="/BadmintonWebsite/home.php" class="hover:text-gray-400">HOME</a></li>
        <li><a href="/BadmintonWebsite/pricing.php" class="hover:text-gray-400">PRICING</a></li>
        <li><a href="/BadmintonWebsite/courts.php" class="hover:text-gray-400">BOOK NOW</a></li>
        <li><a href="/BadmintonWebsite/history.php" class="hover:text-gray-400">HISTORY</a></li>
        <li><a href="/BadmintonWebsite/profile.php" class="hover:text-gray-400">
          <svg class="w-5 h-6" style="fill: #3a5dd6;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>        </a></li>
        <li><a href="/BadmintonWebsite/login.php" class="hover:text-gray-400">
          <svg class="w-5 h-6" style="fill: #3a5dd6;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
        </a></li>
      </ul>
    </div>
  </nav>

<div class="bg-white rounded-lg m-10">
    <?php
        // The code checks if the year and week parameters are present in the URL query string ($_GET) using isset().
        // If the parameters are present, the setISODate() method is called on the $dt object to set the specified year and week.
        // If the parameters are not present, the setISODate() method is called with the current year and week obtained from $dt.

        $dt = new DateTime();
        if (isset($_GET['year']) && isset($_GET['week'])) {
          $dt->setISODate($_GET['year'], $_GET['week']);
        } else {
          $dt->setISODate($dt->format('o'), $dt->format('W'));
        }

        $year = $dt->format('o');
        $week = $dt->format('W');
        $month = $dt->format('F');
        $year = $dt->format('Y');
    ?>




  <div class="flex flex-row justify-end">
      <h2 class="text-3xl font-bold text-dtarblue ml-3 md:ml-10 mt-4"><?php echo "$month $year"; ?> </h2>
      <div class="ml-auto my-auto">
        <?php
          $currentWeek = date('W'); // Get the current week number

          // Check if the current week is greater than the minimum week
          if ($week > $currentWeek) {
              echo '<a class="bg-dtarblue text-white  rounded px-3 py-1 mr-3" href="' . $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year . '">Previous Week</a>';
          }
        ?>
        <a class="bg-dtarblue text-white  rounded px-3 py-1 mr-3" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . date('W') . '&year=' . date('o'); ?>">Current Week</a>
        <a class="bg-dtarblue text-white  rounded px-3 py-1 mr-3" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>">Next Week</a>

      </div>
  </div>

  <hr class="border-black mb-3">

  <div class="overflow-x-auto"> 

    <table class="w-full h-full">
        <tr class="text-center">
          <?php
            $dates = array();
            $currentDt = clone $dt; // Create a clone of the DateTime object to maintain the original value

            // Generate the dates for each day and store them in the $dates array
            for ($i = 0; $i < 7; $i++) {
              $dates[$currentDt->format('l')] = $currentDt->format('d/m/Y');
              if ($currentDt->format('d/m/Y') == date('d/m/Y')) {
                echo '<td class="py-1 px-3 text-dtarblue font-bold ">' . $currentDt->format('l') . "<br>" . $currentDt->format('d/m/Y') . "</td>\n";
              } else {
                echo '<td class="py-1 px-3">' . $currentDt->format('l') . "<br>" . $currentDt->format('d/m/Y') . "</td>\n";
              }
              $currentDt->modify('+1 day'); // Increase the date by 1 day
            }
          ?>
        </tr>

        <?php
              $timeslots = timeslots($duration, $cleanup, $start, $end);
              $currentDate = strtotime(date('d/m/Y'));

              foreach ($timeslots as $ts) {
                echo '<tr>';
                foreach ($dates as $day => $date) {
                  $dateTime = $date . ' ' . $ts;
                  $isBooked = false;
              
                  if (isset($bookedSlots[$court_id])) {
                    $isBooked = in_array($dateTime, $bookedSlots[$court_id]);
                  }

                  if ($isBooked) {
                    echo '<td class="py-3 text-center"><button class="mx-3  bg-red-500 text-white w-40 h-14 rounded px-3 py-3 book" style="cursor: default;" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" style="display: inline-block; vertical-align: middle;">
                              <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                              <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/>
                            </svg>
                          </button></td>';
                  } 
                  // elseif ($isPastDate) {
                  //   echo '<td class="py-3 text-center"><button class="mx-3 text-white w-40 rounded px-3 py-3 book bg-gray-400" disabled>' . $ts . '</button></td>';
                  // } 
                  else {
                    echo '<td class="py-3 text-center"><button class="mx-3 bg-dtarblue text-white w-40 rounded px-3 py-3 book" data-timeslot="' . $dateTime . '">' . $ts . '</button></td>';
                  }
                }
                echo '</tr>';
              }
          ?>
      </table>
    </div>
  </div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Booking: <span id="#slot"></span></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Time and Date</label>
                            <input type="text" readonly name ="timeslot" id="timeslot" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Total Hours</label>
                            <input type="number" name="duration" id="duration" class="form-control">
                            <input type="hidden" name="duration_hidden" id="duration_hidden" value="">
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Email</label>
                            <input type="text"  name ="email" id="email" class="form-control">
                        </div>  -->
                        <div class="form-group pull-right">
                            <button class = "btn btn-primary" type="submit" name="submit">submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

    </div>
    </div>
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-4 w-full">
    <div class="container mx-auto flex items-center justify-center">
      <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
    </div>
  </footer>
  <script>
      $(".book").click(function(){
          var timeslot = $(this).attr('data-timeslot');
          $("#slot").html(timeslot);
          $("#timeslot").val(timeslot);
          $("#myModal").modal("show");

          if (timeslot.endsWith(" 11:00PM")) {
              $("#duration").prop("disabled", true).val("1");
              $("#duration_hidden").val("1");
          } else {
              $("#duration").prop("disabled", false).val("");
              $("#duration_hidden").removeAttr("value"); // Remove the value attribute from the hidden input field
          }
      });
    </script>
</body>
</html>


    
