<?php
  include "config.php";
  $booking_id = $_GET['id'];

  // Check if the token is set in the session
  if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];

    // Retrieve the user's token from the database
   if($_SESSION['user_id']){
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

              if (isset($_POST['submit'])) {

                $history = $_POST['history'];    
                
                $sql="UPDATE BOOKING SET booking_history = '$history', update_at = NOW() WHERE booking_id = '$booking_id'";
                $result3 = mysqli_query($conn, $sql);
            
                if ($result3) {
                    echo "<script>alert('This booking status has been updated!');</script>";
                    // echo "<script>window.location.href = 'admin.php';</script>";
                }
            }
            elseif (isset($_POST['back'])) {
              echo "<script>window.location.href = 'adminManage.php';</script>";
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
    
  } else {
    // Token not set in the session, user is not authenticated
    // Redirect the user to the login page or perform any necessary action
    echo "<script>window.location.href = 'logout.php';</script>";
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
  <title>Booking Details</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>

<body>

<!-- component -->
<body class="font-poppins antialiased">
<div id="view" class="h-screen w-screen flex flex-row bg-dtarblue">
        <!--Sidebar-->
<!--Sidebar-->
      <div
        id="sidebar"
        class="bg-white h-screen md:block shadow-xl px-3 w-72"
      >
        <div class="space-y-6 md:space-y-10 mt-10">
          <img src="/BadmintonWebsite/assets/logo.png" class="w-24 mx-auto h-auto mb-10" alt="">

          <div id="profile" class="space-y-3">
            <svg class="w-16 h-16 rounded-full mx-auto bg-gray-200" fill='black'  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            <div>
              <h2
                class="font-medium text-xs md:text-sm text-center text-dtarblue">
                    <?php  echo $_SESSION['user_name']?>
              </h2>

              <p class="text-xs text-gray-500 text-center"><?php  echo $_SESSION['user_role']?></p>
            </div>
          </div>
          <div id="menu" class="flex flex-col space-y-2">
          <?php if($_SESSION['user_role'] != 'Staff')
          {
            echo ' <a href="/BadmintonWebsite/adminHome.php" class="text-sm font-medium text-gray-700 py-2 px-2">
                    <svg class="w-6 h-6 fill-current inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                      <span class="">View Dashboard</span>
                    </a>';
          }
         ?>
            <a href="/BadmintonWebsite/adminProfile.php" class="text-sm font-medium text-gray-700 py-2 px-2"
            >
            <svg class="w-5 h-6 fill-current inline-block"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            <span class="">View Profile</span>
            </a>
            <a href="/BadmintonWebsite/adminChooseCalendar.php" class="text-sm font-medium text-gray-700 py-2 px-2"
            >
              <svg class="w-6 h-6 fill-current inline-block" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
              </svg>
              <span class="">View Calendar</span>
            </a>
            <?php if($_SESSION['user_role'] != 'Staff')
          {
            echo ' <a href="/BadmintonWebsite/adminPlaceList.php" class="text-sm font-medium text-gray-700 py-2 px-2">
            <svg  class="w-5 h-6 fill-current inline-block" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M139.61 35.5a12 12 0 0 0-17 0L58.93 98.81l-22.7-22.12a12 12 0 0 0-17 0L3.53 92.41a12 12 0 0 0 0 17l47.59 47.4a12.78 12.78 0 0 0 17.61 0l15.59-15.62L156.52 69a12.09 12.09 0 0 0 .09-17zm0 159.19a12 12 0 0 0-17 0l-63.68 63.72-22.7-22.1a12 12 0 0 0-17 0L3.53 252a12 12 0 0 0 0 17L51 316.5a12.77 12.77 0 0 0 17.6 0l15.7-15.69 72.2-72.22a12 12 0 0 0 .09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 0 0 0-96zm432 16H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h288a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"/></svg>
                      <span class="">Manage Court and Hall</span>
                    </a>';
          }
         ?>
            <a
              href="/BadmintonWebsite/adminManage.php"
              class="text-sm font-medium text-gray-700 py-2 px-2"
            >
            <svg class="w-6 h-6 fill-current inline-block" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65V152c0-13.3-10.7-24-24-24z"/></svg>
              <span class="">Booking History</span>
            </a>
            <a href="/BadmintonWebsite/adminUserList.php" class="text-sm font-medium text-gray-700 py-2 px-2">
                          <svg class="w-5 h-6 fill-current inline-block"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                          <span class="">Manage Customer</span>
            </a>
            <?php if($_SESSION['user_role'] != 'Staff')
              {
                echo '       
                        <a href="/BadmintonWebsite/adminStaffList.php" class="text-sm font-medium text-gray-700 py-2 px-2">
                          <svg class="w-5 h-6 fill-current inline-block"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                          <span class="">Manage Staff</span>
                        </a>
                      ';
              }
            ?>
            <a
              href="/BadmintonWebsite/logout.php"
              class="text-sm font-medium text-gray-700 py-2 px-2"
            >
            <svg class="w-6 h-6 fill-current inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
              <span class="">Log Out</span>
            </a>
          </div>

        </div>
      </div>
<!--Main Content-->

<section class="pt-7 px-7 md:px-20 w-full">
    <h2 class="text-3xl font-bold mb-4 text-white">Booking Details</h2>

<div>
    <div class="container rounded bg-white mt-5 p-10 w-full">
                <!-- <div class="mb-5">
                  <h1 class="font-bold text-xl">Personal Information</h1>
                </div> -->
                <form method="POST">
                  <?php

                    $sql =" SELECT *
                            FROM booking_court BC
                            JOIN booking B ON BC.booking_id = B.booking_id
                            JOIN court C ON BC.court_id = C.court_id
                            JOIN hall H ON H.hall_id = C.hall_id
                            JOIN customer CS ON CS.customer_id = B.customer_id
                            LEFT JOIN payment P ON P.customer_id = CS.customer_id
                            LEFT JOIN payment_method PM ON PM.paymentmethod_id = P.paymentmethod_id
                            WHERE B.booking_id = '$booking_id' ";

                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                          //fetch data
                            // $booking_id = $row['booking_id'];
                            $customer_name = $row['customer_name'];
                            $booking_usedatetime = $row['booking_usedatetime'];
                            $hall_name = $row['hall_name'];
                            $court_name = $row['court_num'];
                            $booking_duration = $row['booking_duration'];
                            $payment_method = $row['paymentmethod_title'];
                            $booking_history = $row['booking_history'];

                            if($payment_method == NULL)
                              $payment_method = 'The booking process is still pending.';

                          //Date for court use time
                            $booked = $row['booking_usedatetime'];
                            $booked_usetime = DateTime::createFromFormat('Y-m-d H:i:s', $booked);
                            $usedatetime = $booked_usetime->format('d/m/Y h:iA');
                            $day = $booked_usetime->format('l'); // Retrieves the day
                            $date = $booked_usetime->format('d/m/Y'); // Retrieves the date
                            $time = $booked_usetime->format('h:i A'); // Retrieves the time

                        }
                          //set price for selected day
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
                       
                      <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                        <div class="mt-2 relative w-full">
                            <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Booking ID</label>
                                <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold" value="<?php echo $booking_id ?>">    
                            </div>
                        </div>
                        <div class="mt-2 relative w-full">
                            <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Customer Name</label>
                                <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold" value="<?php echo $customer_name ?>">        
                                </div>
                        </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Court Date</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold" value="<?php echo $date . ' ' . $time ?>">        
                                </div>
                            </div>
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Hall</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold"  value="<?php echo $hall_name ?>">      
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Court</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold" value="<?php echo $court_name ?>">        
                                </div>
                            </div>
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Duration</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold"  value="<?php echo $booking_duration ?>">      
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Total Price</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2 w-full font-semibold" value="RM <?php echo ($price = $dayPrices[strtolower($day)] * $booking_duration); ?>">
                                </div>
                            </div>
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Payment Method</label>
                                    <input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold"  value="<?php echo ($payment_method == 'fpx') ? 'Online Payment' : $payment_method; ?>">      
                                </div>
                            </div>
                        </div> 
                        <div class="mt-4 relative w-full">
                            <div class="border-2 border-gray-400 p-1 rounded-lg mt-2" style="width:49.5%">
                                <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Booking Status</label>
                                <?php 
                                if($booking_history == 'Paid' || $booking_history == 'Pending' ){
                                   echo '<input disabled style="background-color: #c3c3c3;" type="text" class="form-control px-1 py-2  w-full font-semibold"  value="'.$booking_history.'">';      
                                }
                                else{

                                ?>
                                <select class="form-control px-1 py-2 w-full font-semibold" name="history">
                                    <option value="Paid" <?php if($booking_history == 'Paid') echo 'selected'; ?>>Paid</option>
                                    <option value="In Process" <?php if($booking_history == 'In Process') echo 'selected'; ?>>In Process</option>
                                </select>
                                <?php }
                                ?>
                            </div>
                        </div>

                        <div class="mt-5 justify-end my-auto flex gap-5">
                            <button name="back" class="px-4 py-1 rounded-lg bg-gray-300">Back</button>  

                            <!-- <a href="#" onclick="printFile('Print.php?id=<?php echo $bookingID; ?>'); return false;">
                              <button class="px-4 py-1 rounded-lg bg-gray-300 h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 0 512 512">
                                  <path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                </svg>
                              </button>
                            </a> -->

                            <?php 
                            if($booking_history == 'In Process'){
                              echo '<button name="submit" class="px-4 py-1 rounded-lg" style="background-color: #e9ff62;">Save</button>';
                            }
                            else{
                              echo '
                                  <div class="">
                                    <a href="#" onclick="printFile(\'Print.php?id='.$booking_id.'\')">
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
                            ?>
                          </div>
                    </form>

                <?php
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
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

</div>
</section>

     
    </div>
  </body>




</body>
