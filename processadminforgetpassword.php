<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // Output connection error in JSON format
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $new_password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Basic validation
    if (empty($email) || empty($new_password)) {
        echo json_encode(['error' => 'Please fill all the fields.']);
        exit();
    }

    // Prepare a statement to check if the email exists
    $query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        // Output preparation error in JSON format
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
        exit();
    }

    // Bind parameters and execute the statement
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email found, hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare a statement to update the password
        $update_query = "UPDATE admins SET password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);
        if (!$update_stmt) {
            // Output preparation error in JSON format
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to prepare update statement: ' . $conn->error]);
            exit();
        }

        // Bind parameters and execute the update statement
        $update_stmt->bind_param('ss', $hashed_password, $email);
        if ($update_stmt->execute()) {
            // Output success message in JSON format
            echo json_encode(['success' => 'Password changed successfully.']);
        } else {
            // Output update error in JSON format
            echo json_encode(['error' => 'Error updating password: ' . $update_stmt->error]);
        }

        // Close the update statement
        $update_stmt->close();
    } else {
        // Email not found
        echo json_encode(['error' => 'Email not registered.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
