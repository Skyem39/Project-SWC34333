<?php
session_start();
include 'db_connect.php'; // Include database connection file

// Get form data
$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : '';
$room_number = isset($_POST['room_number']) ? $_POST['room_number'] : '';
$room_type = isset($_POST['room_type']) ? $_POST['room_type'] : '';
$check_in = isset($_POST['check_in']) ? $_POST['check_in'] : '';
$check_out = isset($_POST['check_out']) ? $_POST['check_out'] : '';
$special_requests = isset($_POST['special_requests']) ? $_POST['special_requests'] : '';  // Ensure it captures text input
$guests = isset($_POST['num_guests']) ? $_POST['num_guests'] : 1; // Default to 1 if not provided

// Calculate the number of days for the stay
$days = 0;
if ($check_in && $check_out) {
    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);
    $interval = $check_in_date->diff($check_out_date);
    $days = $interval->days;
}

// Set room rates based on room type
$rate = 0;
switch ($room_type) {
    case 'standard':
        $rate = 110; // Rate for Standard Room
        break;
    case 'deluxe':
        $rate = 220; // Rate for Deluxe Room
        break;
    case 'executive':
        $rate = 350; // Rate for Executive Room
        break;
    default:
        $rate = 0; // Invalid room type
}

// Calculate the total payment
$total_payment = $days * $rate;

// Debugging: Check for calculation issues
if ($total_payment == 0 && $days > 0) {
    echo "Error: Total payment calculation failed. Check room type and rates.<br>";
    exit;
}

// Check room availability before proceeding with the booking
$query = "
    SELECT * FROM bookings 
    WHERE room_number = ? 
    AND (
        (check_in_date <= ? AND check_out_date >= ?) OR 
        (check_in_date <= ? AND check_out_date >= ?)
    )
";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'sssss', $room_number, $check_in, $check_in, $check_out, $check_out);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Room is already booked for the selected dates
    echo "
    <html>
    <head>
        <title>Booking Failed</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
                background-color: #f4f4f4;
            }
            .container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #FFD700;
            }
            p {
                font-size: 18px;
                color: #333;
            }
            a {
                text-decoration: none;
                color: #fff;
                background-color: #FFD700;
                padding: 10px 20px;
                border-radius: 5px;
                display: inline-block;
                margin-top: 20px;
            }
            a:hover {
                background-color: #000;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Room Booking Unsuccessful</h1>
            <p>Sorry, your room is already booked for the selected dates.</p>
            <a href='bookings.html'>Back to Bookings</a>
        </div>
    </body>
    </html>";
    exit;
}

// Prepare and execute the query to insert booking details into the database
$query = "INSERT INTO bookings (customer_name, room_number, room_type, guests, check_in_date, check_out_date, total_payment, special_request) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ssssssds', $customerName, $room_number, $room_type, $guests, $check_in, $check_out, $total_payment, $special_requests);

// Check if the statement was successfully executed
if (mysqli_stmt_execute($stmt)) {
    // Store booking details in the session for the confirmation page
    $_SESSION['booking_info'] = [
        'customerName' => $customerName,
        'roomNumber' => $room_number,
        'roomType' => $room_type,
        'checkIn' => $check_in,
        'checkOut' => $check_out,
        'guests' => $guests,
        'requests' => $special_requests,
        'totalPayment' => $total_payment
    ];

    // Redirect to the confirmation page
    header("Location: confirmation.php");
    exit();
} else {
    echo "Error: " . mysqli_stmt_error($stmt);
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
