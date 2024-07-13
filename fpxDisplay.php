
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
                echo "<script>window.location.href = 'history.php';</script>";
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/BadmintonWebsite/styles.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
  <title>FPX Form</title>
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
        <li><a href="/BadmintonWebsite/court.php" class="hover:text-gray-400">BOOK NOW</a></li>
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

<div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 pb-10 ">
    <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700" style="max-width: 600px">
        <div class="w-full pt-1 pb-5">
            <div class="bg-dtarblue text-white overflow-hidden rounded-full w-20 h-20 -mt-16 mx-auto shadow-lg flex justify-center items-center">
                <i class="mdi mdi-credit-card-outline text-3xl"></i>
            </div>
        </div>
        <div class="mb-5">
            <h1 class="text-center font-bold text-xl">Fill in your details.</h1>
        </div>
              <form method="POST">

              <?php
                    $sql = "SELECT * FROM customer 
                            JOIN online_payment 
                            ON customer.customer_id = online_payment.customer_id
                            WHERE online_payment.customer_id = ' $customerID'";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                      
                      while ($row = mysqli_fetch_assoc($result)) {
                ?>

                <div class="mb-4">
                  <label for="name" class="block mb-2">Name</label>
                  <input type="text" id="name" name="name" class="w-full border border-gray-300 p-2 rounded-md font-semibold" placeholder="Enter your name" value="<?php echo $row['customer_name'] ?>" disabled>
                </div>
                <div class="mb-4">
                  <label for="email" class="block mb-2">Email</label>
                  <input type="email" id="email" name="email" class="w-full border border-gray-300 p-2 rounded-md font-semibold" placeholder="Enter your email" value="<?php echo $row['customer_email'] ?>" disabled>
                </div>
                <div class="mb-4">
                  <label for="name" class="block mb-2">Amount Paid</label>
                  <input type="text" id="name" name="name" class="w-full border border-gray-300 p-2 rounded-md font-semibold" placeholder="Enter your name" style="color: red" value="RM <?php echo $_SESSION['selected_booking_price'] ?>" disabled>
                </div>
                <div class="mb-4">
                  <label for="name" class="block mb-2">Current Balance</label>
                  <input type="text" id="name" name="name" class="w-full border border-gray-300 p-2 rounded-md font-semibold" placeholder="Enter your name" value="RM <?php echo $row['after_balance'] ?>" disabled>
                </div>

                <div class="mb-4">
                  <label for="amount" class="block mb-2 text-l" style="color: red">**Please note that adding money to your account e-Wallet can only be done in person at our physical counter. Online reloads are not available.</label>                </div>
                <?php

                  }
                }
                ?>
        <div>
            <button name="submit" class="mt-10 block w-full max-w-xs mx-auto bg-dtarblue hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">OK</button>
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
