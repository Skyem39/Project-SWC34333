<?php
// Start the session
session_start();

// Debugging: Check if session is working and booking_info is set
// Uncomment the following line to debug session data
// var_dump($_SESSION);

// Check if booking information exists in session
if (isset($_SESSION['booking_info'])) {
    $bookingInfo = $_SESSION['booking_info'];

    // Escape any user input to prevent XSS attacks
    $customerName = htmlspecialchars($bookingInfo['customerName']);
    $roomNumber = htmlspecialchars($bookingInfo['roomNumber']);
    $roomType = htmlspecialchars($bookingInfo['roomType']);
    $checkIn = htmlspecialchars($bookingInfo['checkIn']);
    $checkOut = htmlspecialchars($bookingInfo['checkOut']);
    $guests = htmlspecialchars($bookingInfo['guests']);
    $requests = htmlspecialchars($bookingInfo['requests']);
    $totalPayment = htmlspecialchars($bookingInfo['totalPayment']);

    // Display the booking confirmation page
    echo "
    <html>
    <head>
        <title>Booking Confirmation</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .container { max-width: 600px; margin: auto; padding: 20px; background: #f9f9f9; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
            h1 { color: #FFD700; }
            p { font-size: 18px; color: #333; }
            a { text-decoration: none; color: #fff; background-color: #FFD700; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-top: 20px; }
            a:hover { background-color: #000000; }
            button { padding: 10px 20px; background-color: #FFD700; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
            button:hover { background-color: #000000; }
        </style>
        <script>
            // JavaScript function to trigger the print dialog
            function printPage() {
                window.print();
            }
        </script>
    </head>
    <body>
        <div class='container'>
            <h1>Booking Confirmation</h1>
            <p>Thank you, $customerName.</p>
            <p>Room Number: $roomNumber</p>
            <p>Room Type: $roomType</p>
            <p>Check-in Date: $checkIn</p>
            <p>Check-out Date: $checkOut</p>
            <p>Number of Guests: $guests</p>
            <p>Special Requests: $requests</p>
            <p>Total Payment: RM $totalPayment</p>
            <a href='index.html'>Back to Homepage</a>
            <br><br>
            <!-- Print Button -->
            <button onclick='printPage()'>Print Receipt</button>
        </div>
    </body>
    </html>";
} else {
    echo "<p>No booking information found.</p>";
}
?>
