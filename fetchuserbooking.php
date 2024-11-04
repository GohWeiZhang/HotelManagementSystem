<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Retrieve user_email from session
$user_email = $_SESSION['email'];
$response = [];

// Prepare and execute the query to fetch booking information
$stmt = $conn->prepare("SELECT room_name, checkin_date, checkout_date, total_price, user_name, user_phone, booking_id, number_of_people FROM bookings WHERE user_email = ?");
if ($stmt) {
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user has bookings
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($room_name, $checkin_date, $checkout_date, $total_price, $user_name, $user_phone, $booking_id, $number_of_people);
        $bookings = [];

        while ($stmt->fetch()) {
            $bookings[] = [
                'room_name' => $room_name,
                'checkin_date' => $checkin_date,
                'checkout_date' => $checkout_date,
                'total_price' => $total_price,
                'user_name' => $user_name,
                'user_phone' => $user_phone,
                'booking_id' => $booking_id,
                'number_of_people' => $number_of_people
            ];
        }

        // Return bookings as JSON
        $response = ['success' => true, 'bookings' => $bookings];
    } else {
        $response = ['error' => 'No bookings found for this user.'];
    }

    $stmt->close();
} else {
    $response = ['error' => 'Failed to prepare SQL statement.'];
}

// Close the database connection
$conn->close();

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
