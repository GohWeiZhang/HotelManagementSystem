<?php
// Database connection details
$servername = "localhost";  // Change if using a different server
$username = "root";         // Replace with your MySQL username
$password = "";             // Replace with your MySQL password
$dbname = "user";           // Your database name

// Attempt database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// Query to count the number of registered users
$sql = "SELECT COUNT(*) AS user_count FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $userCount = $row['user_count'];
} else {
    $userCount = 0;
}




// Close connection
$conn->close();

// Return the user count as JSON
echo json_encode(array("registered_count" => $userCount));
?>
