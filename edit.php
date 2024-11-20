<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$dbname = 'hotelbookingdb';
$username = 'root';
$password = '1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the booking ID (id) from the URL
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

    // Handle form submission (to update booking)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form data using the correct field names
        $customerName = $_POST['customer_name'];
        $roomNumber = $_POST['room_number'];
        $roomType = $_POST['room_type'];
        $numGuests = $_POST['guests'];
        $checkInDate = $_POST['check_in_date'];
        $checkOutDate = $_POST['check_out_date'];
        $totalPayment = $_POST['total_payment'];
        $specialRequests = $_POST['special_requests'];

        // Update the booking record in the database
        $updateStmt = $pdo->prepare("UPDATE bookings SET customer_name = :customerName, room_number = :roomNumber, room_type = :roomType, num_guests = :numGuests, check_in_date = :checkInDate, check_out_date = :checkOutDate, total_payment = :totalPayment, special_requests = :specialRequests WHERE id = :id");
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
            echo "Booking updated successfully!";
        } else {
            echo "Failed to update booking.";
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

        a {
            display: block;
            width: 100%;
            padding: 0.8rem;
            margin-top: 1rem;
            background-color: #FFD700;
            color: white;
            text-align: center;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        a:hover {
            background-color: #000000;
            color: white;
            transition: background-color 0.3s ease-in;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomTypeSelect = document.getElementById('room-type');
            const checkInInput = document.getElementById('check-in');
            const checkOutInput = document.getElementById('check-out');
            const totalPaymentInput = document.getElementById('total-payment');
            const roomNumberSelect = document.getElementById('room-number');

            function calculateTotalPayment() {
                // Get the room price based on the selected room type
                let roomPrice = 0;
                switch (roomTypeSelect.value) {
                    case 'standard':
                        roomPrice = 110;
                        break;
                    case 'deluxe':
                        roomPrice = 220;
                        break;
                    case 'executive':
                        roomPrice = 350;
                        break;
                }

                // Calculate the number of nights
                const checkInDate = new Date(checkInInput.value);
                const checkOutDate = new Date(checkOutInput.value);
                const timeDifference = checkOutDate - checkInDate;
                const numNights = timeDifference / (1000 * 3600 * 24); // Convert milliseconds to days

                // Calculate the total payment (based only on room price and number of nights)
                const totalPayment = numNights * roomPrice;
                totalPaymentInput.value = totalPayment.toFixed(2); // Update the total payment field
            }

            // Function to update room numbers based on room type
            function updateRoomNumbers() {
                let startRoom, endRoom;
                switch (roomTypeSelect.value) {
                    case 'standard':
                        startRoom = 1;
                        endRoom = 50;
                        break;
                    case 'deluxe':
                        startRoom = 51;
                        endRoom = 100;
                        break;
                    case 'executive':
                        startRoom = 101;
                        endRoom = 150;
                        break;
                }

                // Clear previous room numbers
                roomNumberSelect.innerHTML = '';

                // Populate room numbers based on the selected room type
                for (let i = startRoom; i <= endRoom; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = 'Room ' + i;
                    if (i == <?php echo $roomNumber; ?>) {
                        option.selected = true; // Keep the selected room number
                    }
                    roomNumberSelect.appendChild(option);
                }
            }

            // Event listeners to trigger the calculation when any relevant field changes
            roomTypeSelect.addEventListener('change', function() {
                updateRoomNumbers();
                calculateTotalPayment();
            });
            checkInInput.addEventListener('change', calculateTotalPayment);
            checkOutInput.addEventListener('change', calculateTotalPayment);

            // Initialize the page with the correct room numbers and total payment
            updateRoomNumbers();
            calculateTotalPayment();
        });
    </script>

</head>
<body>
    <div class="container">
        <h1>Edit Booking Record</h1>
        <form action="edit_booking.php?id=<?php echo $booking['id']; ?>" method="post">
            <label for="customer-name">Customer Name</label>
            <input type="text" id="customer-name" name="customer_name" value="<?php echo $customerName; ?>" required>

            <label for="room-type">Room Type</label>
            <select id="room-type" name="room_type">
                <option value="standard" <?php echo $roomType == 'standard' ? 'selected' : ''; ?>>Standard Room - RM110/night</option>
                <option value="deluxe" <?php echo $roomType == 'deluxe' ? 'selected' : ''; ?>>Deluxe Room - RM220/night</option>
                <option value="executive" <?php echo $roomType == 'executive' ? 'selected' : ''; ?>>Executive Room - RM350/night</option>
            </select>

            <label for="room-number">Room Number</label>
            <select id="room-number" name="room_number">
                <!-- Room numbers are populated dynamically by JavaScript -->
            </select>

            <label for="num-guests">Number of Guests</label>
            <input type="number" id="num-guests" name="num_guests" value="<?php echo $numGuests; ?>" required>

            <label for="check-in">Check-in Date</label>
            <input type="date" id="check-in" name="check_in_date" value="<?php echo $checkInDate; ?>" required>

            <label for="check-out">Check-out Date</label>
            <input type="date" id="check-out" name="check_out_date" value="<?php echo $checkOutDate; ?>" required>

            <label for="total-payment">Total Payment</label>
            <input type="text" id="total-payment" name="total_payment" value="<?php echo $totalPayment; ?>" readonly>

            <label for="special-requests">Special Requests</label>
            <textarea id="special-requests" name="special_requests" rows="4"><?php echo $specialRequests; ?></textarea>

            <button type="submit">Update Booking</button>
        </form>
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>
