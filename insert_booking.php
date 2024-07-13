<?php
include "config.php";

if (isset($_POST['time'])) {
    $selectedTime = $_POST['selected_time']; // Assuming you have a form field named 'selected_time'

    // Prepare the SQL statement
    $stmt = $db->prepare('INSERT INTO booking (booking_datetime) VALUES (?)');
    
    // Bind the selected time as a parameter to the prepared statement
    $stmt->bind_param('s', $selectedTime);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo 'Time successfully booked.';
    } else {
        echo 'Failed to book the time.';
    }
    
    // Close the statement and database connection
    $stmt->close();
    $db->close();
}
  
// // Prepare the SQL statement
// $stmt = $db->prepare('INSERT INTO booking (booking_datetime, booking_usedatetime, create_at) VALUES (:booking_datetime, :booking_usedatetime, NOW())');

// $stmt->bindParam(':booking_datetime', $start_date);
// $stmt->bindParam(':booking_usedatetime', $end_date);

// // Execute the statement to insert the new booking
// if ($stmt->execute()) {
//     // Insertion was successful
//     $response = array('status' => 'success', 'message' => 'Booking inserted successfully');
// } else {
//     // Insertion failed
//     $response = array('status' => 'error', 'message' => 'Failed to insert booking');
// }

// // Set the Content-Type header to JSON
// header('Content-Type: application/json');

// // Output the response as JSON
// echo json_encode($response);

// // End script execution to prevent any additional output
// exit;


?>
