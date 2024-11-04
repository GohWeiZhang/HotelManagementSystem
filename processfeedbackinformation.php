<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, send an error response
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch client information
$stmt = $conn->prepare("SELECT title, comment FROM feedback ORDER BY title");
$stmt->execute();
$result = $stmt->get_result();


$clients = array();

if ($result->num_rows > 0) {
    // Fetch each row and add to the clients array
    while($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Send the client data as JSON
header('Content-Type: application/json');
echo json_encode($clients);
?>