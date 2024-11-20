<?php
// Assuming you are using PDO for database interaction
$pdo = new PDO('mysql:host=localhost;dbname=hotel', 'username', 'password');

// Get selected room type and dates from AJAX request
$roomType = $_POST['room_type'];
$checkInDate = $_POST['check_in'];
$checkOutDate = $_POST['check_out'];

// Query to get all available rooms based on the selected type and dates
$query = "
    SELECT room_number FROM rooms
    WHERE room_type = :room_type 
    AND room_number NOT IN (
        SELECT room_number FROM bookings 
        WHERE room_type = :room_type 
        AND (
            (check_in_date <= :check_out AND check_out_date >= :check_in)
        )
    )";

$stmt = $pdo->prepare($query);
$stmt->execute([
    ':room_type' => $roomType,
    ':check_in' => $checkInDate,
    ':check_out' => $checkOutDate
]);

// Fetch all available rooms
$availableRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return available rooms as JSON
echo json_encode($availableRooms);
?>
