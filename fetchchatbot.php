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

// Fetch user's name based on their email
$sql = "SELECT name FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user's name
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
} else {
    // If the user is not found, display a default name
    $user_name = "Guest";
}

$stmt->close();
$conn->close();

// Return the user's name as JSON
header('Content-Type: application/json');
echo json_encode(['name' => $user_name]);
