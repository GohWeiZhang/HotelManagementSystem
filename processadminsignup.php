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

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password for security

    // Input validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href = 'adminsignup.html';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'adminsignup.html';</script>";
        exit();
    }

    if (!preg_match("/^01[0-9]{8,9}$/", $phone)) {
        echo "<script>alert('Invalid phone number format. It should be 10 or 11 digits and start with 01.'); window.location.href = 'adminsignup.html';</script>";
        exit();
    }

    // SQL query to insert data into the `admins` table
    $sql = "INSERT INTO admins (name, email, phone, password) VALUES (?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $password);  // Bind parameters to prevent SQL injection

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Redirect to login page after successful signup
        header("Location: adminlogin.html");
        exit();
    } else {
        // Show an alert for failure to register
        echo "<script>alert('Failed to register. Please try again.'); window.location.href = 'adminsignup.html';</script>";
        exit();
    }

    // Close the prepared statement and the connection
    $stmt->close();
    $conn->close();
}
?>
