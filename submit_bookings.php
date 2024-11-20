<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $roomType = htmlspecialchars($_POST['room-type']);
    $checkIn = htmlspecialchars($_POST['check-in']);
    $checkOut = htmlspecialchars($_POST['check-out']);
    $guests = htmlspecialchars($_POST['guests']);
    $requests = htmlspecialchars($_POST['requests']);

    // Display the booking details (for demonstration)
    echo "<h1>Booking Confirmation</h1>";
    echo "<p><strong>Room Type:</strong> $roomType</p>";
    echo "<p><strong>Check-in Date:</strong> $checkIn</p>";
    echo "<p><strong>Check-out Date:</strong> $checkOut</p>";
    echo "<p><strong>Number of Guests:</strong> $guests</p>";
    echo "<p><strong>Special Requests:</strong> $requests</p>";

    // Example of saving to a database (optional)
    // $conn = new mysqli("servername", "username", "password", "dbname");
    // if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    // $sql = "INSERT INTO bookings (room_type, check_in, check_out, guests, requests) VALUES ('$roomType', '$checkIn', '$checkOut', '$guests', '$requests')";
    // $conn->query($sql);
    // $conn->close();

    // Example: redirecting to a thank-you page
    // header("Location: thank_you.php");
    // exit();
} else {
    echo "Invalid form submission.";
}
?>
