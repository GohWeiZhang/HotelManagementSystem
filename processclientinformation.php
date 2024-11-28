<?php


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
$sql = "SELECT name, phone, email FROM users ORDER BY name";
$result = $conn->query($sql);

$clients = array();

if ($result) { // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch each row and add to the clients array
        while($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }
} else {
    // Handle SQL error
    error_log("SQL Error: " . $conn->error); // Log the error for debugging
    echo json_encode(["error" => "An error occurred while fetching client information."]);
    exit; // Exit the script
}

// Close the database connection
$conn->close();

// Send the client data as JSON
header('Content-Type: application/json');
echo json_encode($clients);
?>
