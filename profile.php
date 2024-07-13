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
              if (isset($_POST['save'])) {
                  //cust data
                  $name = $_POST['name'];
                  $email = $_POST['email'];
                  $phone = $_POST['phone'];
                  $ic = $_POST['ic'];
                  $address = $_POST['address'];
                  $age = $_POST['age'];

                  //update customer table
                  $sql = "UPDATE customer SET customer_ic='$ic', customer_phone='$phone', customer_address='$address',
                          customer_name='$name', customer_age='$age', token = '$token' , update_at = NOW() WHERE customer_id = '$customerID'";
                  $result = mysqli_query($conn, $sql);
                  
                  if ($result) {

                    echo "<script>alert('You profile have been updated!');</script>";

                    // Check if the new email already exists in the table
                    $checkEmailQuery = "SELECT * FROM customer WHERE customer_email = '$email'";
                    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
                    if (mysqli_num_rows($checkEmailResult) > 0) {
                        echo "<script>alert('However, the email already exists. Please choose a different email.');</script>";
                    } else {
                        $sql = "UPDATE customer SET customer_email = '$email' WHERE customer_id = '$customerID'";
                        $result = mysqli_query($conn, $sql);
                
                        if ($result) {
                          // echo "<script>alert('You profile have been updated!');</script>";
                        } else {
                          echo "<script>alert('Invalid data. Please try again.');</script>";
                        }
                    }
                    echo "<script>window.location.href = 'profile.php';</script>";            
                  }
                }

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
          echo "<script>window.location.href = 'logout.php';</script>";        }
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
<body class="bg-dtarblue relative h-screen">
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
  

<section class="pt-7 px-7 md:px-20">
    <h2 class="text-3xl font-bold mb-4 text-white">Profile</h2>

<div>
<div class="container rounded bg-white mt-5 p-10">
  <form action="" method="POST">


    <?php
    if(!isset($_SESSION['token']))
    {
      echo '
      <div class="container rounded bg-white mt-5">
        <div class="w-full">
            <div class="px-3 py-3">
                <div class="flex justify-between items-center font-semibold">
                    <h6 style="color: red; font-size:23px;">Log In to view your profile information!</h6>
                </div>                        
            </div>
          </div>
      </div>';
    }
    else{
      echo
      '    
      <div class="mb-5">
        <h1 class="font-bold text-xl">Personal Information</h1>
      </div>';

      $sql = "SELECT * FROM customer 
      JOIN online_payment 
      ON customer.customer_id = online_payment.customer_id
      WHERE online_payment.customer_id = '$customerID'";

      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>

    <div class="flex flex-col md:flex-row gap-0 md:gap-4">
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Name</label>
          <input required type="text" name="name" class="form-control p-1 w-full" placeholder="Name" value="<?php echo $row['customer_name'] ?>">
        </div>
      </div>
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">IC</label>
          <input required type="text" name="ic" class="form-control p-1 w-full" placeholder="IC" value="<?php echo $row['customer_ic'] ?>">
        </div>
      </div>
    </div>
    <div class="flex flex-col md:flex-row gap-0 md:gap-4">
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Email</label>
          <input required type="text" name="email" class="form-control p-1 w-full" placeholder="Email" value="<?php echo $row['customer_email'] ?>">
        </div>
      </div>
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Phone Number</label>
          <input required type="text" name="phone" class="form-control p-1 w-full" placeholder="Phone Number" value="<?php echo $row['customer_phone'] ?>">
        </div>
      </div>
    </div>
    <div class="flex flex-col md:flex-row gap-0 md:gap-4">
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Age</label>
          <input type="text" name="age" class="form-control p-1 w-full" placeholder="Age" value="<?php echo $row['customer_age'] ?>">
        </div>
      </div>
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Address</label>
          <input type="text" name="address" class="form-control p-1 w-full" placeholder="Address" value="<?php echo $row['customer_address'] ?>">
        </div>
      </div>
    </div><br><br>

    <hr style="border: 1px solid black;"><br>

    <div class="mb-5">
      <h1 class="font-bold text-xl">Account e-Wallet</h1>
    </div>
    <div class="flex flex-col md:flex-row gap-0 md:gap-4">
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2">
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for="">Current Balance</label>
          <input type="text" class="form-control p-1 w-full" placeholder="Name" value="RM <?php echo $row['after_balance'] ?>" style="background-color: #c3c3c3;" disabled>
        </div>
      </div>
      <div class="mt-2 relative w-full">
        <div class="border-2 border-gray-400 p-1 rounded-lg mt-2" hidden>
          <label class="bg-white absolute left-3 top-0 text-xs px-1" for=""></label>
          <input type="text" class="form-control p-1 w-full" style="background-color: #c3c3c3;" hidden>
        </div>
      </div>
    </div><br>

    <label for="amount" class="block mb-2 text-l font-semibold" style="color: red">
      **Please note that adding money to your e-Wallet can only be done in person at our physical <br> counter. Online reloads are not available.
    </label>
    
    <!-- File upload button -->
    <div class="mt-5 text-right">
      <button class="px-4 py-1 rounded-lg bg-dtargreen" name="save">Save</button>
    </div>

  <?php
        }
      }
    }
  ?>
  </form>
</div>
</div>
</div>

</div>

    
</div>
</section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-4 absolute bottom-0 w-full">
    <div class="container mx-auto flex items-center justify-center">
      <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>