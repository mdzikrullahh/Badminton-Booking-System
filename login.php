<?php
  include "config.php";

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (isset($_POST['role']) && $_POST['role'] === 'customer'){
            $sql = "SELECT * FROM customer WHERE customer_email = '$email' AND customer_pass = '$password'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['customer_id'] = $row['customer_id'];
                        // $_SESSION['customer_name'] = $row['customer_name'];
                        // $_SESSION['customer_email'] = $row['customer_email'];

                        // Generate a new token
                        $token = bin2hex(random_bytes(16));
                        $_SESSION['token'] =  $token;

                        // Update the token in the database
                        $customerId = $row['customer_id'];

                        $updateTokenSql = "UPDATE customer SET token = '$token', update_at = NOW() WHERE customer_id = '$customerId'";
                        $updateTokenResult = mysqli_query($conn, $updateTokenSql);

                        if ($updateTokenResult) {
                            // Token updated successfully
                            echo "<script>alert('Welcome back, {$row['customer_name']}!');</script>";
                            echo "<script>window.location.href = 'home.php';</script>";
                        } else {
                            // Failed to update the token
                            echo "<script>alert('Failed to update the token');</script>";
                        }
                    }
                }
            } else {
                echo "<script>alert('Invalid email or password. Please Insert again!');</script>";
            }
        }  
       
        else if (isset($_POST['role']) && $_POST['role'] === 'staff')
        {
            $sql = "SELECT * FROM user WHERE user_email = '$email' AND user_pass = '$password'";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Fetch data
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $roleID = $row['role_id'];
            
                        $sqlRole = "SELECT role_title FROM role WHERE role_id = '$roleID'";
                        $resultRole = mysqli_query($conn, $sqlRole);
            
                        if ($resultRole) {
                            if (mysqli_num_rows($resultRole) > 0) {
                                while ($rowRole = mysqli_fetch_assoc($resultRole)) {
                                    $_SESSION['user_role'] = $rowRole['role_title'];
                                }
                            }
                        }
            
                        // Generate a new token
                        $token = bin2hex(random_bytes(16));
                        $_SESSION['token'] = $token;
            
                        // Update the token in the database
                        $user_id = $row['user_id'];
                        $updateTokenSql = "UPDATE user SET token = '$token', update_at = NOW() WHERE user_id = '$user_id'";
                        $updateTokenResult = mysqli_query($conn, $updateTokenSql);
            
                        if ($updateTokenResult && $roleID == 1) {
                            // Token updated successfully
                            echo "<script>alert('Welcome back, {$row['user_name']}!');</script>";
                            echo "<script>window.location.href = 'adminHome.php';</script>";
                        } elseif ($updateTokenResult && $roleID == 2){
                            echo "<script>alert('Welcome back, {$row['user_name']}!');</script>";
                            echo "<script>window.location.href = 'adminManage.php';</script>";
                        }else {
                            // Failed to update the token
                            echo "<script>alert('Failed to update the token');</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Invalid email or password. Please try again!');</script>";
                }
            } else {
                echo "<script>alert('An error occurred while processing your request.');</script>";
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
  <title>Log In Page</title>
  <link rel="icon" href="/BadmintonWebsite/assets/logo.jpg" class="w-full" type="image/icon type">
</head>
<body style="color: #3a5dd6;">
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
                <img class="w-full h-14 mr-2" src="/BadmintonWebsite/assets/logo.png" alt="logo">    
            </a>
            <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="" method="POST">
                        <div class="grid-cols-2 grid items-start">

                            <div class="flex items-center gap-4">
                                <input name="role" id="customer" type="radio" class="w-4 h-4 border border-gray-300 rounded" value="customer" checked>
                                <label for="customer" class="text-gray-500">User</label>
                            </div>
                            <div class="flex h-5 items-center gap-4">
                                <input name="role" id="staff" type="radio" class="w-4 h-4 border border-gray-300 rounded" value="staff">
                                <label for="staff" class="text-gray-500">Staff</label>
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="name@company.com" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                        </div>
                        <button type="submit" name ="submit" class="bg-dtarblue w-full text-white focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign in</button>
                        <p class="text-sm font-light text-gray-500">
                            Don’t have an account yet? <a href="/BadmintonWebsite/register.php" class="font-medium text-dtarblue hover:underline">Register now</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
      </section>
</body>
