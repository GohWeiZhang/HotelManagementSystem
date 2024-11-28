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

// Query to get booking quantities per room
$sql = "SELECT room_name, COUNT(*) AS booking_count FROM bookings GROUP BY room_name";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return the data as JSON
echo json_encode($data);

// Close the database connection
$conn->close();
?>
