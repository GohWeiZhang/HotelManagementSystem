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
    die("<script>alert('ERROR: Could not connect to the database.'); window.location='signup.php';</script>");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    // Simple validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        echo "<script>alert('Please fill all fields'); window.location='signup.php';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location='signup.php';</script>";
        exit();
    }

    if (!preg_match("/^01[0-9]{8,9}$/", $phone)) {
        echo "<script>alert('Invalid phone number. It must be 10 or 11 digits long and start with 01.'); window.location='signup.php';</script>";
        exit();
    }

    // Enforce strong password policies
    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.location='signup.php';</script>";
        exit();
    }

    if (!preg_match("/[A-Z]/", $password)) {
        echo "<script>alert('Password must contain at least one uppercase letter.'); window.location='signup.php';</script>";
        exit();
    }

    if (!preg_match("/[a-z]/", $password)) {
        echo "<script>alert('Password must contain at least one lowercase letter.'); window.location='signup.php';</script>";
        exit();
    }

    if (!preg_match("/[0-9]/", $password)) {
        echo "<script>alert('Password must contain at least one number.'); window.location='signup.php';</script>";
        exit();
    }

    if (!preg_match("/[\W]/", $password)) { // \W checks for any special character
        echo "<script>alert('Password must contain at least one special character.'); window.location='signup.php';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert statement
    $sql = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('ERROR: Could not execute query.'); window.location='signup.php';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('ERROR: Could not prepare query.'); window.location='signup.php';</script>";
    }
} else {
    echo "<script>alert('Form was not submitted.'); window.location='signup.php';</script>";
}

// Close connection
$conn->close();
?>
