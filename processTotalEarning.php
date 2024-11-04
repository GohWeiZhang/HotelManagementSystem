<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Query to sum up the total price from the bookings table
$sql = "SELECT SUM(total_price) as total_earnings FROM bookings";
$result = $conn->query($sql);

$totalEarnings = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalEarnings = $row['total_earnings'] ?? 0;
}

echo json_encode(['success' => true, 'total_earnings' => $totalEarnings]);

// Close the database connection
$conn->close();
?>
