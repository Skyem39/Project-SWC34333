<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection credentials
$host = 'localhost';
$dbname = 'hotelbookingdb';
$username = 'root';
$password = '1234';

try {
    // Establish database connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the booking ID from the URL (e.g., ?id=9)
    $booking_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Check if the booking ID is provided
    if (!$booking_id) {
        die("Booking ID is missing. Please return to the <a href='admin_dashboard.php'>admin dashboard</a> and select a booking to edit.");
    }

    // Fetch the booking details from the database
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :id");
    $stmt->bindParam(':id', $booking_id, PDO::PARAM_INT);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no booking found, display an error message
    if (!$booking) {
        die("Booking not found.");
    }

    // Pre-fill form data with existing booking data
    $customerName = $booking['customer_name'];
    $roomType = $booking['room_type'];
    $roomNumber = $booking['room_number'];
    $numGuests = $booking['guests'];
    $checkInDate = $booking['check_in_date'];
    $checkOutDate = $booking['check_out_date'];
    $totalPayment = $booking['total_payment'];
    $specialRequests = $booking['special_request'];

    // Handle form submission to update booking record
    $updateSuccess = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data
        $customerName = $_POST['customer_name'];
        $roomNumber = $_POST['room_number'];
        $roomType = $_POST['room_type'];
        $numGuests = $_POST['num_guests'];
        $checkInDate = $_POST['check_in_date'];
        $checkOutDate = $_POST['check_out_date'];
        $totalPayment = $_POST['total_payment'];
        $specialRequests = $_POST['special_requests'];

        // Update the booking record in the database
        $updateStmt = $pdo->prepare("UPDATE bookings SET customer_name = :customerName, room_number = :roomNumber, room_type = :roomType, guests = :numGuests, check_in_date = :checkInDate, check_out_date = :checkOutDate, total_payment = :totalPayment, special_request = :specialRequests WHERE id = :id");
        $updateStmt->bindParam(':customerName', $customerName);
        $updateStmt->bindParam(':roomNumber', $roomNumber);
        $updateStmt->bindParam(':roomType', $roomType);
        $updateStmt->bindParam(':numGuests', $numGuests);
        $updateStmt->bindParam(':checkInDate', $checkInDate);
        $updateStmt->bindParam(':checkOutDate', $checkOutDate);
        $updateStmt->bindParam(':totalPayment', $totalPayment);
        $updateStmt->bindParam(':specialRequests', $specialRequests);
        $updateStmt->bindParam(':id', $booking_id, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            $updateSuccess = true;
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit booking record at Bukit Pandan Hotel.">
    <title>Edit Booking Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #000000;
        }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: bold;
            margin-top: 1rem;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            margin-top: 1.5rem;
            background-color: #FFD700;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #000000;
            color: white;
            transition: background-color 0.3s ease-in;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-content button {
            background-color: #000;
            color: white;
            padding: 0.8rem 1.2rem;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #FFD700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Booking Record</h1>
        <form action="edit_booking.php?id=<?php echo $booking['id']; ?>" method="post">
            <label for="customer-name">Customer Name</label>
            <input type="text" id="customer-name" name="customer_name" value="<?php echo htmlspecialchars($customerName); ?>" required>

            <label for="room-number">Room Number</label>
            <select id="room-number" name="room_number" required>
                <?php
                $startRoom = 101;
                $endRoom = 150;
                if ($roomType == 'standard') {
                    $startRoom = 1;
                    $endRoom = 50;
                } elseif ($roomType == 'deluxe') {
                    $startRoom = 51;
                    $endRoom = 100;
                }

                for ($i = $startRoom; $i <= $endRoom; $i++) {
                    echo '<option value="' . $i . '" ' . ($i == $roomNumber ? 'selected' : '') . '>Room ' . $i . '</option>';
                }
                ?>
            </select>

            <label for="room-type">Room Type</label>
            <select id="room-type" name="room_type" required>
                <option value="standard" <?php echo ($roomType == 'standard') ? 'selected' : ''; ?>>Standard Room - RM110/night</option>
                <option value="deluxe" <?php echo ($roomType == 'deluxe') ? 'selected' : ''; ?>>Deluxe Room - RM220/night</option>
                <option value="executive" <?php echo ($roomType == 'executive') ? 'selected' : ''; ?>>Executive Room - RM350/night</option>
            </select>

            <label for="num-guests">Number of Guests</label>
            <input type="text" id="num-guests" name="num_guests" value="<?php echo htmlspecialchars($numGuests); ?>" required>

            <label for="check-in">Check-in Date</label>
            <input type="date" id="check-in" name="check_in_date" value="<?php echo $checkInDate; ?>" required>

            <label for="check-out">Check-out Date</label>
            <input type="date" id="check-out" name="check_out_date" value="<?php echo $checkOutDate; ?>" required>

            <label for="total-payment">Total Payment (RM)</label>
            <input type="text" id="total-payment" name="total_payment" value="<?php echo $totalPayment; ?>" readonly>

            <label for="requests">Special Requests</label>
            <textarea id="requests" name="special_requests" rows="4"><?php echo htmlspecialchars($specialRequests); ?></textarea>

            <button type="submit">Edit</button>
            <button type="button" onclick="window.location.href='admin_dashboard.php'">Back to Admin Dashboard</button>
        </form>
    </div>

    <?php if ($updateSuccess): ?>
        <div id="successModal" class="modal">
            <div class="modal-content">
                <p>Booking updated successfully!</p>
                <button onclick="window.location.href='admin_dashboard.php'">Back to Dashboard</button>
            </div>
        </div>
        <script>
            document.getElementById('successModal').style.display = 'block';
        </script>
    <?php endif; ?>
</body>
</html>
