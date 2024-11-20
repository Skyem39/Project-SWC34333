<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php'; // Ensure you have a database connection file

// Fetch all records for display
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #000000;
            color: white;
        }
        .button {
            padding: 0.5rem 1rem;
            color: white;
            background-color: #FFD700;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 0.5rem;
        }
        .button:hover {
            background-color: #000000;
        }
        .link-button {
            text-decoration: none;
            color: #FFD700;
        }
        .link-button:hover {
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Room Number</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Room Type</th>
                    <th>Total Payment</th>
                    <th>Guests</th>
                    <th>Special Requests</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['room_number']) ?></td>
                            <td><?= htmlspecialchars($row['check_in_date']) ?></td>
                            <td><?= htmlspecialchars($row['check_out_date']) ?></td>
                            <td><?= htmlspecialchars($row['room_type']) ?></td>
                            <td><?= htmlspecialchars($row['total_payment']) ?></td>
                            <td><?= htmlspecialchars($row['guests']) ?></td>
                            <td><?= htmlspecialchars($row['special_request']) ?></td>
                            <td>
                                <!-- Edit link -->
                                <a href="edit.php?id=<?= urlencode($row['id']) ?>" class="link-button">Edit</a>

                                <!-- Delete link -->
                                <a href="delete.php?id=<?= urlencode($row['id']) ?>" 
                                   class="link-button" 
                                   onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Link to add a new booking record -->
        <a href="add.php" class="button">Add New Record</a>

        <!-- Back to Admin Dashboard button -->
        <a href="admin.php" class="button">Admin Panel</a>
    </div>
</body>
</html>
