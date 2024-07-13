<?php
  include "config.php";

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
  <title>Homepage</title>
  <link rel="icon" href="/badmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>
<body>
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

  <!-- Hero Section -->
  <section class="bg-no-repeat bg-center bg-cover" style="background-image: url(/badmintonWebsite/assets/homepage.png); width: auto; height:600px">
  </section>

  <!-- About Section -->
  <section class="p-10 text-center">
          <h2 class="text-4xl font-bold mb-4">About Us</h2>
          <p class="text-2xl text-gray-700 mb-4">Dewan Tun Abdul Razak is a leading badminton facility offering state-of-the-art courts and a welcoming community for players of all ages and skill levels. We strive to provide an exceptional badminton experience to our members and visitors.</p>
          <a href="#" class="text-blue-500 hover:underline">
            <a href="/BadmintonWebsite/courts.php"><button class="px-4 py-1 rounded-lg" style="background-color: #e9ff62;">
              Book Now
            </button></a>
          </a>
  </section>

  <div class="text-white bg-dtarblue">
    <div class="p-7 md:px-20">
      <h2 class="text-2xl font-bold tracking-tight text-center">Our Badminton Halls</h2>
  
      <div class="mt-7 flex flex-col lg:flex-row gap-y-10 gap-x-5 justify-center">
        <div class="group relative w-96">
          <div class="aspect-h-1 aspect-w-1 w-96 overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
            <img src="/DTAR/assets/1.png" alt="" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
          </div>
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-md">
                <a href="#">
                <a href="#">
                  <span aria-hidden="true" class="absolute inset-0"></span>
                  Dewan Lama
                </a>
              </h3>
            </div>
            <p class="text-sm font-medium">RM 10-12</p>
          </div>
        </div>
        <div class="group relative w-96">
          <div class="aspect-h-1 aspect-w-1 w-96 overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
            <img src="/DTAR/assets/3.png" alt="" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
          </div>
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-md">
                <a href="#">
                  <span aria-hidden="true" class="absolute inset-0"></span>
                  Dewan Kenangan Tun Abdul Razak
                </a>
              </h3>
            </div>
            <p class="text-sm font-medium">RM 10-12</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  


  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-4">
    <div class="container mx-auto flex items-center justify-center">
      <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
