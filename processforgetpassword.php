<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Output connection error in JSON format
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $new_password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Basic validation
    if (empty($email) || empty($new_password)) {
        echo "Please fill all the fields.";
        exit();
    }

    // Enforce strong password policies
    if (strlen($new_password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.location='forgetpassword.php';</script>";
        exit();
    }

    if (!preg_match("/[A-Z]/", $new_password)) {
        echo "<script>alert('Password must contain at least one uppercase letter.'); window.location='forgetpassword.php';</script>";
        exit();
    }

    if (!preg_match("/[a-z]/", $new_password)) {
        echo "<script>alert('Password must contain at least one lowercase letter.'); window.location='forgetpassword.php';</script>";
        exit();
    }

    if (!preg_match("/[0-9]/", $new_password)) {
        echo "<script>alert('Password must contain at least one number.'); window.location='forgetpassword.php';</script>";
        exit();
    }

    if (!preg_match("/[\W]/", $new_password)) { // \W checks for any special character
        echo "<script>alert('Password must contain at least one special character.'); window.location='forgetpassword.php';</script>";
        exit();
    }

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email found, update the password
        // Hash the new password before storing it
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $update_query = "UPDATE users SET password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ss', $hashed_password, $email);

        if ($update_stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error updating password.";
        }
    } else {
        // Email not found
        echo "Email not registered.";
    }

    // Close the statement
    $stmt->close();
    $update_stmt->close();
}

// Close the connection
$conn->close();
?>
