<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'user not logged in.']);
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

$response = array();

if ($user_email) {
    // Prepare and execute the query to find user data based on email
    $stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE email = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($name, $email, $phone);
            $stmt->fetch();

            // Return user data as JSON
            $response = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            );
        } else {
            $response = array(
                'error' => 'User not found.'
            );
        }

        $stmt->close();
    } else {
        $response = array(
            'error' => 'Failed to prepare SQL statement.'
        );
    }
} else {
    $response = array(
        'error' => 'No user email found in session.'
    );
}

// Close the database connection
$conn->close();

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>