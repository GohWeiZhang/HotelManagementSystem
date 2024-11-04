<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Query to retrieve booking data
$query = "SELECT room_name, checkin_date, checkout_date, total_price, user_name, user_email, user_phone, booking_id, number_of_people FROM bookings";
$result = $conn->query($query);

// Prepare an array to store the bookings
$bookings = [];

if ($result->num_rows > 0) {
    // Fetch all booking data into the array
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
} 

// Close the database connection
$conn->close();

// Return the bookings array
echo json_encode($bookings);
?>
