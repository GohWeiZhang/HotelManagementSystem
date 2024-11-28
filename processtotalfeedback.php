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

// Query to count the number of feedback entries
$sql = "SELECT COUNT(*) AS feedback_count FROM feedback"; // Replace 'feedback' with your feedback table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $feedbackCount = $row['feedback_count'];
} else {
    $feedbackCount = 0;
}

// Close connection
$conn->close();

// Return the feedback count as JSON
echo json_encode(array("feedback_count" => $feedbackCount));
?>
