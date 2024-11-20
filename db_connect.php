<?php
// Database configuration
$host = 'localhost';         // MySQL host, usually 'localhost'
$dbname = 'hotelbookingdb';    // Replace with your database name
$username = 'root';  // Replace with your MySQL username
$password = '1234';  // Replace with your MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
