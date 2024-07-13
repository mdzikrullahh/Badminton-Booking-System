<?php

    $booking_id = $_GET['id'];

    // Connect to DB
    require "config.php";

    $sql = "DELETE FROM booking WHERE booking_id = '$booking_id'";
    
    // On successful deletion, redirect to the original page using header() method
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);

        if(isset($_SESSION['customer_id'])){
            echo '<script>alert("Your booking has been cancelled!");</script>';
            echo "<script>window.location.href = 'history.php';</script>";
        }
        elseif(isset($_SESSION['user_id'])){
            echo '<script>alert("Customer\'s booking has been deleted!");</script>';
            echo "<script>window.location.href = 'adminManage.php';</script>";
        }
        exit;
    } else {
        echo '<script>alert("Failed to delete!");</script>';
        header('Location: history.php');
        exit;
    }
?>
