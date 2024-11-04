<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Attempt database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("ERROR: Could not connect. " . $conn->connect_error);
}
session_start();
session_unset();
session_destroy();
header('Location: login.php');
?>
