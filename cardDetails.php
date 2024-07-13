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

              if (isset($_POST['submit'])) {
                $method = $_SESSION['selectedPaymentType'];
                $amount =  $_SESSION['selected_booking_price'];
                $booking_id =  $_SESSION['selected_booking_id'];
            
                $sql = "SELECT paymentmethod_id FROM payment_method WHERE paymentmethod_title = '$method' ";
                $result = mysqli_query($conn, $sql);
            
                if ($result) {
                    // Get the auto-generated payment method ID
                    // $paymentMethodID = mysqli_insert_id($conn);
                    // echo $paymentMethodID .",". $amount .",". $booking_id .",". $customerID . ". ". $token;

                    while ($row = mysqli_fetch_assoc($result)) {

                        $paymentMethodID = $row['paymentmethod_id'];
  
                      }
                    // Use the payment method ID to insert data into payment table
                    $sql = "INSERT INTO payment(payment_datetime, payment_amount, booking_id, customer_id, paymentmethod_id, update_at, create_at, token) 
                                        VALUES(NOW(), '$amount', '$booking_id', '$customerID', '$paymentMethodID', NOW(), NOW(), '$token')";
                    $result2 = mysqli_query($conn, $sql);
            
                    if ($result2) {
                        $sql = "UPDATE booking SET booking_history = 'Paid' , update_at = NOW() WHERE booking_id = '$booking_id'";
                        $result3 = mysqli_query($conn, $sql);
            
                        if ($result3) {
                            echo "<script>alert('Payment successful! Your booking is confirmed. Have a great time!');</script>";
                            echo "<script>window.location.href = 'history.php';</script>";
                        } else {
                            echo "<script>alert('Error in delete query: " . mysqli_error($conn) . "');</script>";
                        }
                    } else {
                        echo "<script>alert('Error in second query: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error in first query: " . mysqli_error($conn) . "');</script>";
                }
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/BadmintonWebsite/styles.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
  <title>Card Form</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>
<body class="bg-dtarblue relative">
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

  <!-- component -->
<style>@import url(https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css);</style>

<div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 pb-10">
    <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700" style="max-width: 600px">
        <div class="w-full pt-1 pb-5">
            <div class="bg-dtarblue text-white overflow-hidden rounded-full w-20 h-20 -mt-16 mx-auto shadow-lg flex justify-center items-center">
                <i class="mdi mdi-credit-card-outline text-3xl"></i>
            </div>
        </div>
        <form method="POST">
            <div class="mb-5">
                <h1 class="text-center font-bold text-xl ">Fill in your details.</h1>
            </div>
            <div class="px-2">
                <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png" class="h-8 ml-3 pl-40">
                </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Name on card</label>
                <div>
                    <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text" required/>
                </div>
            </div>
            <div class="mb-3">
                <label class="font-bold text-sm mb-2 ml-1">Card number</label>
                <div>
                    <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="0000 0000 0000 0000" type="text" required/>
                </div>
            </div>
            <div class="mb-3 -mx-2 flex items-end">
                <div class="px-2 w-1/2">
                    <label class="font-bold text-sm mb-2 ml-1">Expiration date</label>
                    <div>
                        <select class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer" required>
                            <option value="">Select Month</option>
                            <option value="01">01 - January</option>
                            <option value="02">02 - February</option>
                            <option value="03">03 - March</option>
                            <option value="04">04 - April</option>
                            <option value="05">05 - May</option>
                            <option value="06">06 - June</option>
                            <option value="07">07 - July</option>
                            <option value="08">08 - August</option>
                            <option value="09">09 - September</option>
                            <option value="10">10 - October</option>
                            <option value="11">11 - November</option>
                            <option value="12">12 - December</option>
                        </select>
                    </div>
                </div>
                <div class="px-2 w-1/2">
                    <select class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer" required>
                        <option value="">Select Year</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                    </select>
                </div>
            </div>
            <div class="mb-10">
                <label class="font-bold text-sm mb-2 ml-1">Security code</label>
                <div>
                    <input class="w-32 px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="000" type="text" required/>
                </div>
            </div>
            <div>
                <button onClick="javascript: return confirm('Are you sure you want to choose this method?')" name="submit" class="mt-10 block w-full max-w-xs mx-auto bg-dtarblue hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> PAY NOW</button>
            </div>
        </form>
    </div>
</div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-4 absolute w-full bottom-0">
        <div class="container mx-auto flex items-center justify-center">
          <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
        </div>
      </footer>
</body>
