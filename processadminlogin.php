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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Simple validation
    if (empty($email) || empty($password)) {
        header("Location: adminlogin.php?error=emptyfields");
        exit();
    }

    // Prepare a statement to get user data
    $sql = "SELECT id, password FROM admins WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Start a new session
                session_start();
                $_SESSION['user_id'] = $id;
                $_SESSION['email'] = $email;

                // Redirect to homepage after successful login
                header("Location: adminhomepage.php");
                exit();
            } else {
                // Incorrect password
                header("Location: adminlogin.php?error=invalidpassword");
                exit();
            }
        } else {
            // No user found with this email
            header("Location: adminlogin.php?error=nouser");
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        die("ERROR: Could not prepare query: " . $conn->error);
    }
} else {
    die("Form was not submitted.");
}

// Close connection
$conn->close();
?>
