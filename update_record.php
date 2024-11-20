<?php
require 'db_connect.php'; // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = intval($_POST['id']);
    $customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
    $roomNumber = mysqli_real_escape_string($conn, $_POST['room_number']);
    $roomType = mysqli_real_escape_string($conn, $_POST['room_type']);
    $numGuests = intval($_POST['guests']);
    $checkIn = mysqli_real_escape_string($conn, $_POST['check_in']);
    $checkOut = mysqli_real_escape_string($conn, $_POST['check_out']);
    $totalPayment = mysqli_real_escape_string($conn, $_POST['total_payment']);
    $specialRequests = mysqli_real_escape_string($conn, $_POST['special_requests']);

    // Prepare the SQL update query
    $sql = "UPDATE bookings 
            SET customerName = ?, room_number = ?, room_type = ?, guests = ?, check_in = ?, check_out = ?, total_payment = ?, special_requests = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisdsis", $customerName, $roomNumber, $roomType, $numGuests, $checkIn, $checkOut, $totalPayment, $specialRequests, $id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the admin dashboard after success
        header("Location: admin_dashboard.php?message=Record updated successfully");
        exit();
    } else {
        // If there's an error, display an error message
        die("Error: Unable to update record. " . $stmt->error);
    }
} else {
    // If the form is not submitted via POST, redirect or show an error
    die("Error: Invalid request method.");
}
?>
