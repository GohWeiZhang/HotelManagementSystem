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

// Query to get the count of bookings for each number of people
$query = "SELECT number_of_people, COUNT(*) AS booking_count FROM bookings GROUP BY number_of_people";
$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'number_of_people' => $row['number_of_people'],
            'booking_count' => $row['booking_count']
        ];
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No bookings found']);
    exit();
}

$conn->close();
echo json_encode($data);
?>
