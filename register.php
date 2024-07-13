<?php
  include "config.php";

    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $ic = $_POST['ic'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // $address = $_POST['address'];
        // $age = $_POST['age'];

        $token = bin2hex(random_bytes(16));

        //create array to check error
        $errors = array();

        //validation using strlen() to check length of phone number
        if (strlen($phone) > 11 || strlen($phone) < 10) {
            $errors [] = "<script>alert('Phone number is exceed or too short!');</script>";
        }
        //validation to  Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM customer WHERE customer_email = '$email'";
        $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
        if (mysqli_num_rows($checkEmailResult) > 0) {
            $errors[] = "<script>alert('Email already exists. Please use a different email.');</script>";
        }
        
        if (empty($errors)){

            //insert new user into customer table 
            $sql = "INSERT INTO customer(customer_name, customer_ic, customer_pass, customer_email, customer_phone, create_at, token) 
                    VALUES ('$name', '$ic', '$password','$email', '$phone', NOW(), '$token')";

            $result = mysqli_query($conn, $sql);

            if($result){

                //if register completed, assign rm450 to user account
                $amount = 450;

                //get customer id that just registered
                $customerID = mysqli_insert_id($conn) ;

                $sql = "INSERT INTO online_payment(current_balance, after_balance, update_at, create_at, token, customer_id) 
                        VALUES ('$amount', '$amount', NOW(), NOW(), '$token', '$customerID')";

                $result = mysqli_query($conn, $sql);
               
                if($result){
                    echo "<script>alert('Your account has been successfully registered.');</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                }

            }
            else
                echo "<script>alert('Query failed');</script>";
            

        }
        else{
                foreach($errors as $error)
                echo $error;

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
  <title>Register Page</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>
<body style="color: #3a5dd6;">
    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
                <img class="w-full h-14 mr-2" src="/BadmintonWebsite/assets/logo.png" alt="logo">    
            </a>
            <div class="w-full bg-white rounded-lg shadow sm:max-w-md">
                <div class="p-6 space-y-4 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Register now
                    </h1>
                    <form class="space-y-4" action="#" method="POST">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="name" name="name" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg  block w-full p-2.5 " placeholder="John" required="">
                        </div>
                        <div>
                            <label for="IC" class="block mb-2 text-sm font-medium text-gray-900">IC</label>
                            <input type="IC" name="ic" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg  block w-full p-2.5 " placeholder="010101130303" required="">
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                            <input type="phone" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 " placeholder="0123455678" required="">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 " placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" required="">
                        </div>
                        <button style="background-color:#3a5dd6" type="submit" name="submit" class="w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create an account</button>
                        <p class="text-sm font-light text-gray-500">
                            Already have an account? <a href="/BadmintonWebsite/login.php" class="font-medium text-dtarblue hover:underline">Log in here</a>
                        </p>
                        <p class="text-sm font-light text-gray-500">
                            Register as a staff? <a href="/BadmintonWebsite/registerStaff.php" class="font-medium text-dtarblue hover:underline">Register here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
      </section>
</body>
