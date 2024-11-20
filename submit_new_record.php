<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = 'localhost';
$dbname = 'hotelbookingdb';
$username = 'root';
$password = '1234';

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle form submission (to create a new booking)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data using the correct field names
        $customerName = isset($_POST['customerName']) ? trim($_POST['customerName']) : null;
        $roomNumber = isset($_POST['room_number']) ? trim($_POST['room_number']) : null;
        $roomType = isset($_POST['room_type']) ? trim($_POST['room_type']) : null;
        $numGuests = isset($_POST['num_guests']) ? trim($_POST['num_guests']) : null;
        $checkInDate = isset($_POST['check_in']) ? $_POST['check_in'] : null;
        $checkOutDate = isset($_POST['check_out']) ? $_POST['check_out'] : null;
        $totalPayment = isset($_POST['total_payment']) ? trim($_POST['total_payment']) : null;
        $specialRequest = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : null;

        // Validate required fields
        if ($customerName && $roomNumber && $roomType && $numGuests && $checkInDate && $checkOutDate && $totalPayment) {
            // Insert the new booking into the database
            $stmt = $pdo->prepare("INSERT INTO bookings (customer_name, room_number, room_type, guests, check_in_date, check_out_date, total_payment, special_request) 
                                   VALUES (:customerName, :roomNumber, :roomType, :numGuests, :checkInDate, :checkOutDate, :totalPayment, :specialRequest)");
            $stmt->bindParam(':customerName', $customerName);
            $stmt->bindParam(':roomNumber', $roomNumber);
            $stmt->bindParam(':roomType', $roomType);
            $stmt->bindParam(':numGuests', $numGuests);
            $stmt->bindParam(':checkInDate', $checkInDate);
            $stmt->bindParam(':checkOutDate', $checkOutDate);
            $stmt->bindParam(':totalPayment', $totalPayment);
            $stmt->bindParam(':specialRequest', $specialRequest);

            // Execute and handle the result
            if ($stmt->execute()) {
                echo "Booking created successfully!";
                // Redirect to admin dashboard or any other page
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "Failed to create booking. Please try again.";
                print_r($stmt->errorInfo()); // Debug SQL error
            }
        } else {
            echo "All fields are required!";
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
