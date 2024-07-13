<?php
  include "config.php";
  
  // Check if the token is set in the session
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

              }

          } else {
              // Token mismatch, invalid session
              // Redirect the user to the login page or perform any necessary action
              echo '<script>alert("Your session has expired. Please log in again.");</script>';
              echo "<script>window.location.href = 'logout.php';</script>";
          }
      } else {
          // Failed to retrieve the token from the database
          // Redirect the user to the login page or perform any necessary action
          echo '<script>alert("Your session has expired. Please log in again.");</script>';
          echo "<script>window.location.href = 'logout.php';</script>";          
      }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/BadmintonWebsite/styles.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
  <title>History</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
  <style>
  .booking-details {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .booking-details h6 {
    margin: 5px 0;
    font-size: 14px;
    font-weight: bold;
    color: #0066cc;
  }
</style>
</head>
<body class="bg-dtarblue min-h-screen flex flex-col">
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
          <li><a href="/BadmintonWebsite/logout.php" class="hover:text-gray-400">
          <svg class="w-5 h-6" style="fill: #3a5dd6;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
        </a></li>
      </ul>
    </div>
  </nav>

  <div class="pt-7 px-7 md:px-20">

    <h2 class="text-3xl font-bold mb-4 text-white">Booking History</h2>
    <div>
          <?php 
            if(!isset($_SESSION['token']))
            {
              echo '
              <div class="container rounded bg-white mt-5">
                <div class="flex">

                    <div class="w-full">
                        <div class="px-3 py-3">
                            <div class="flex justify-between items-center font-semibold">
                                <h6 style="color: red; font-size:23px;">Log In to view your booking history!</h6>
                            </div>                        
                        </div>
                      </div>
                  </div>
              </div>';

            }
            else{
              $sql = "SELECT * FROM booking_court BC 
              JOIN booking B 
              ON BC.booking_id = B.booking_id 
              JOIN court C 
              ON BC.court_id = C.court_id 
              JOIN hall H 
              ON H.hall_id = C.hall_id
              WHERE B.customer_id = '$customerID' 
              ORDER BY B.booking_datetime DESC";
              
              $result = mysqli_query($conn, $sql);
  
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  
                  //Date for court use time
                  $booked = $row['booking_usedatetime'];
                  $booked_usetime = DateTime::createFromFormat('Y-m-d H:i:s', $booked);
                  $day = $booked_usetime->format('l'); // Retrieves the day
                  $date = $booked_usetime->format('d/m/Y'); // Retrieves the date
                  $time = $booked_usetime->format('h:i A'); // Retrieves the time
  
                  //date when booking was made
                  $booked2 = $row['booking_datetime'];
                  $booked_made = DateTime::createFromFormat('Y-m-d H:i:s', $booked2);
                  $booked_made = $booked_made->format('d/m/Y h:iA');
  
  
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
  
                  // echo $dayPrices['saturday'];
  
                    echo '
                    <div class="container rounded bg-white my-5">
                      <div class="flex">
                          <div class="border-r">
                              <div class="flex flex-col items-center text-center p-3">
                                  <img class="rounded" src="/BadmintonWebsite/assets/1.png" width="130">
                              </div>
                          </div>
                          <div class="w-full">
                              <div class="px-3 py-3">
                                  <div class="flex justify-between items-center font-semibold">
                                      <h6 class="text-lg">'.$row['hall_name'].'</h6>
                                      <h6 class="text-xl">RM '.$price = $dayPrices[strtolower($day)] * $row['booking_duration'] .'</h6>
                                  </div>
                                  <div class="booking-details">
                                    <h6>ID: '.$row['bookingcourt_id'].'</h6>
                                    <h6>Day: '.$day.'</h6>
                                    <h6>Time: '.$time.'</h6>
                                    <h6>Date: '.$date.'</h6>
                                    <h6>Duration: '.$row['booking_duration'].' Hours</h6>
                                    <h6>Datetime Booking : '.$booked_made.'</h6>
                                  </div>
                                  <div class="flex text-sm justify-between mt-3">';
                                    if($row['booking_history'] == "Pending")
                                    {
                                      echo '<button class=" text-white px-3 p-1 rounded-full mr-1" style="background-color: orange;">Pending</button>
                                      <div class="">
                                        <a href="payment.php?id=' . $row['booking_id'] . '"><button class="text-white px-2 p-1 rounded mr-1" style="background-color: green;">Make Payment</button></a>
                                        <a onClick="javascript: return confirm(\'Are you sure you want to delete this booking?\nPlease note that deleting the booking is irreversible.\');" href="deleteBooking.php?id=' . $row['booking_id'] . '"><button class="text-white px-2 p-1 rounded" style="background-color: red;">Cancel</button></a>
                                      </div>';
                                    }
                                    else if($row['booking_history'] == "In Process"){
                                      echo '<button class=" text-white px-3 p-1 rounded-full mr-1" style="background-color: orange;">In Process</button>';

                                    }
                                    else {
                                      echo '
                                        <button class="text-white px-3 p-1 rounded-full mr-1" style="background-color: green;">Completed</button>
                                        <div class="">
                                          <a href="#" onclick="printFile(\'Print.php?id='.$row['booking_id'].'\')">
                                            <button class="text-white px-2 p-1 rounded mr-1" style="background-color: black; padding-left:10px; width:45px; height:35px;">
                                              <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 0 512 512">
                                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <style>svg{fill:#ffffff}</style>
                                                <path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                              </svg>
                                            </button>
                                          </a>
                                        </div>';
                                    }
  
                                      echo' 
    
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>';
                }
              } 
              else{
                    echo '
                    <div class="container rounded bg-white mt-5">
                      <div class="flex">
  
                          <div class="w-full">
                              <div class="px-3 py-3">
                                  <div class="flex justify-between items-center font-semibold">
                                      <h6 style="font-size:23px;">No Booking History!</h6>
                                  </div>                        
                              </div>
                            </div>
                        </div>
                    </div>';
  
              }     
            }
           
          ?>

      <script>
function printFile(url) {
  var win = window.open(url, '_blank');
  win.addEventListener('load', function() {
    win.print();
    win.onafterprint = function() {
      win.close();
    };
  });
}

      </script>
        <!-- <div class="container rounded bg-white mt-5">
            <div class="flex">
                <div class="border-r">
                    <div class="flex flex-col items-center text-center p-3">
                        <img class="rounded" src="/BadmintonWebsite/assets/1.png" width="130">
                    </div>
                </div>
                <div class="w-full">
                    <div class="px-3 py-3">
                        <div class="flex justify-between items-center font-semibold">
                            <h6 class="text-lg">Dewan Lama (Court A)</h6>
                            <h6 class="text-xl">RM 12</h6>
                        </div>
                        <div class="booking-details">
                          <h6>ID: 12</h6>
                          <h6>Day: Monday</h6>
                          <h6>Date: 9/10/2023</h6>
                          <h6>Duration: 1 hour</h6>
                        </div>
                        <div class="flex text-sm justify-between mt-3">
                            <button class=" text-white px-3 p-1 rounded-full mr-1" style="background-color: green;">Completed</button>
                            <div class="">
                                <button class="text-white px-2 p-1 rounded mr-1" style="background-color: green;">Edit</button>
                                <button class="text-white px-2 p-1 rounded" style="background-color: red;">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
        
    </div>

  </div>


  <br><br>
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-4 mt-auto">
    <div class="container mx-auto flex items-center justify-center">
      <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>