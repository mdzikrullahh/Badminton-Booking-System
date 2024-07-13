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
              echo "<script>window.location.href = 'logout.php';</script>";
          }
      } else {
          // Failed to retrieve the token from the database
          // Redirect the user to the login page or perform any necessary action
          echo "<script>window.location.href = 'login.php';</script>";
      }
    }
    else if($_SESSION['user_id']){
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
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $age = $_POST['age'];
                $phone = $_POST['phone'];
                // $address = $_POST['address'];
            
                $sql = "UPDATE user SET user_name = '$name', user_pass = '$password', user_age = '$age', user_phone = '$phone' WHERE user_id = '$userID'";
                $result = mysqli_query($conn, $sql);
        
                if ($result){
                  echo "<script>alert('You profile have been updated!');</script>";
                }else{
                  echo "<script>alert('Invalid data. Please try again.');</script>";
                }

                // Check if the new email already exists in the table
                $checkEmailQuery = "SELECT * FROM user WHERE user_email = '$email'";
                $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
                if (mysqli_num_rows($checkEmailResult) > 0) {
                    echo "<script>alert('However, the email already exists. Please choose a different email.');</script>";
                } else {
                    $sql = "UPDATE user SET user_email = '$email' WHERE user_id = '$userID'";
                    $result = mysqli_query($conn, $sql);
            
                    if ($result) {
                      // echo "<script>alert('You profile have been updated!');</script>";
                    } else {
                      echo "<script>alert('Invalid data. Please try again.');</script>";
                    }
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
  <title>Profile</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>

<body>

<!-- component -->
<body class="font-poppins antialiased">
<div id="view" class="h-screen w-screen flex flex-row bg-dtarblue">
<!--Sidebar-->
<div
        id="sidebar"
        class="bg-white h-screen md:block shadow-xl px-3 w-72"
      >
        <div class="space-y-6 md:space-y-10 mt-10">
          <img src="/BadmintonWebsite/assets/logo.png" class="w-24 mx-auto h-auto mb-10" alt="">

          <div id="profile" class="space-y-3">
            <svg class="w-16 h-16 rounded-full mx-auto bg-gray-200"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
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
      </div><!--Main Content--><!--Main Content-->

<section class="pt-7 px-7 md:px-20 w-full">
    <h2 class="text-3xl font-bold mb-4 text-white">Profile</h2>

<div>
    <div class="container rounded bg-white mt-5 p-10 w-full">
                <form method="POST">
                  <?php

                    $sql ="SELECT * FROM user WHERE user_id = '$userID'";
                    $result=mysqli_query($conn, $sql);

                    if($result){
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="flex flex-col md:flex-row gap-0 md:gap-4">
                        <div class="mt-2 relative w-full">
                            <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Name</label>
                                <input required type="text" class="form-control p-1  w-full" name="name" placeholder="Name" value="'.$row['user_name'].'">    
                            </div>
                        </div>
                        <div class="mt-2 relative w-full">
                            <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Email</label>
                                <input required type="text" class="form-control p-1  w-full" name="email" placeholder="Email" value="'.$row['user_email'].'">        
                                </div>
                        </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Password</label>
                                    <input required type="password" class="form-control p-1  w-full" name="password" placeholder="password" value="'.$row['user_pass'].'">        
                                </div>
                            </div>
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Phone Number</label>
                                    <input required type="text" class="form-control p-1  w-full" name="phone" placeholder="Phone Number" value="'.$row['user_phone'].'">      
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-0 md:gap-4">
                            <div class="mt-2 relative w-full">
                                <div class="border-2 border-gray-400 p-1 rounded-lg mt-2" style="width:49.5%">
                                    <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Age</label>
                                    <input type="text" class="form-control p-1  w-full" name="age" placeholder="Age" value="'.$row['user_age'].'">        
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-right">
                            <button name="submit" class="px-4 py-1 rounded-lg" style="background-color: #e9ff62;">
                                Save
                              </button>                        
                            </div>
                    </form>';


                      }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
</section>

     
    </div>
  </body>




</body>
