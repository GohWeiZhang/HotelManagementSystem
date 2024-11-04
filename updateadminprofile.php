<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Admin not logged in.']);
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

// Retrieve admin_email from session
$admin_email = $_SESSION['email'];

// Get POST data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Validate input
if (empty($name) || empty($phone)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Name and phone are required.']);
    exit();
}

// Prepare and execute the query to update admin data
$stmt = $conn->prepare("UPDATE admins SET name = ?, phone = ? WHERE email = ?");
if ($stmt) {
    $stmt->bind_param("sss", $name, $phone, $admin_email);
    if ($stmt->execute()) {
        // Success
        $response = array('success' => true);
    } else {
        // Failure
        $response = array('error' => 'Failed to update profile.');
    }
    $stmt->close();
} else {
    $response = array('error' => 'Failed to prepare SQL statement.');
}

// Close the database connection
$conn->close();

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
