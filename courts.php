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

              if(isset($_POST['hall2'])){

                // Retrieve the selected court value
                //DEWAN LAMA
                $_SESSION['selectedCourt'] = $_POST['court'];
                $_SESSION['selectedHall'] = 7002;
                echo "<script>window.location.href = 'book.php';</script>";

            }
            else if(isset($_POST['hall1'])){

                // Retrieve the selected court value
                //DEWAN KENANGAN TUN ABDUL RAZAK
                $_SESSION['selectedCourt'] = $_POST['court'];
                $_SESSION['selectedHall'] = 7001;
                // echo $selectedCourt;
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
          echo "<script>window.location.href = 'login.php';</script>";
      }
    }
    
  } elseif( (isset($_POST['hall1']) || isset($_POST['hall2'])) && !isset($_SESSION['token']))
  {
    // Token not set in the session, user is not authenticated
    // Redirect the user to the login page or perform any necessary action
    echo "<script>alert('Please log in first to book and view schedule');</script>";

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
  <title>Court Selection</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">

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
        <li><a href="/BadmintonWebsite/logout.php" class="hover:text-gray-400">
          <svg class="w-5 h-6" style="fill: #3a5dd6;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
        </a></li>
      </ul>
    </div>
  </nav>
  <section class="py-7 px-7 md:px-20">
    <h2 class="text-3xl font-bold mb-4 text-white">Court Selection</h2>
          <div class="mx-auto mt-16 max-w-2xl lg:max-w-6xl">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">
              <div class="relative col-span-1">
                <form METHOD="POST">
                  <dt class="text-xl font-semibold leading-7 text-white">
                    Dewan Lama
                  </dt>
                  <dd class="my-2 text-sm text-white">This hall boasts two badminton courts with high-quality rubber flooring, providing a safe and optimal playing surface. The rubber floor offers shock absorption, non-slip traction, and noise reduction, enhancing the overall badminton experience for players of all levels.</dd>
                  <?php
                    $query = "SELECT * FROM court WHERE hall_id = 7002";
                    $result = mysqli_query($conn, $query);

                    // Check if the query was successful
                    if ($result) {
                      // Build the options for the select element
                      $options = "";
                      while ($row = mysqli_fetch_assoc($result)) {
                        if($row['court_availability'] == 'available')
                          $options .= "<option value=".$row['court_id'].">".$row['court_num']."</option>";
                        else
                          $options .= "<option value=".$row['court_id']." disabled>".$row['court_num']."</option>";

                      }
                    } else {
                      // Handle the case where the query fails
                      // ...
                      // Add your error handling code here
                    }
                  ?>
                  <div class="relative inline-block">
                    <select name="court" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="dropdown-menu">
                    <option disabled selected>Choose Court</option>
                      <?php echo $options; ?>
                    </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                          <path d="M10 12l-6-6h12l-6 6z" />
                        </svg>
                      </div>
                    </div>
                    <!-- button -->
                    <button class="p-2 text-black rounded bg-dtargreen " name='hall2'><span aria-hidden="true">&rarr;</span></button>
                  </form>
              </div> 

              <!-- second hall -->
              <div class="col-span-2">
                  <img class="w-full h-full rounded-lg object-cover object-top" style="object-position: 50% 30%;" src="/BadmintonWebsite/assets/court1.png" alt="">
              </div>

              <div class="col-span-2">
                  <img class="w-full h-full rounded-lg object-cover object-top" style="object-position: 50% 15%;" src="/BadmintonWebsite/assets/court2.png" alt="">
              </div>
            <div class="relative pr-0 col-span-1">
            <form METHOD="POST">
                <dt class="text-xl font-semibold leading-7 text-white">
                  Dewan Kenangan Tun Abdul Razak
                </dt>
                <dd class="my-2 text-sm text-white">This hall boasts two badminton courts with high-quality rubber flooring, providing a safe and optimal playing surface. The rubber floor offers shock absorption, non-slip traction, and noise reduction, enhancing the overall badminton experience for players of all levels.</dd>

                  <?php
                      $query = "SELECT * FROM court JOIN hall ON court.hall_id = hall.hall_id WHERE hall.hall_id = 7001";
                      $result = mysqli_query($conn, $query);

                      // Check if the query was successful
                      if ($result) {
                        // Build the options for the select element
                        $options = "";
                        while ($row = mysqli_fetch_assoc($result)) {
                          if($row['hall_availability'] == 'available'){
                            if($row['court_availability'] == 'available')
                              $options .= "<option value=".$row['court_id'].">".$row['court_num']."</option>";
                             else
                              $options .= "<option value=".$row['court_id']." disabled>".$row['court_num']."</option>";
                          }else{
                            $options .= "<option value=".$row['court_id']." disabled>".$row['court_num']."</option>";

                          }

  
                        }
                      } else {
                        // Handle the case where the query fails
                        // ...
                        // Add your error handling code here
                      }
                    ?>
                  <div class="relative inline-block">
                    <select name="court" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" id="dropdown-menu">
                    <option disabled selected>Choose Court</option>
                      <?php echo $options; ?>
                    </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M10 12l-6-6h12l-6 6z" />
                    </svg>
                  </div>
                </div>
                <button class="p-2 text-black rounded bg-dtargreen" name='hall1'><span aria-hidden="true">&rarr;</span></button>
              </form>
            </div> 
            </div>
          </div>
        </div>
      </div>
</div>
  </section>
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-4  w-full">
    <div class="container mx-auto flex items-center justify-center">
      <p>&copy; 2023 Dewan Tun Abdul Razak Court. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>