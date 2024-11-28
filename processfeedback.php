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
 
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $comment = $conn->real_escape_string($_POST['comment']);

    if (empty($title) || empty($comment)) {
        header("Location: contactus.php?error=emptyfields");
        exit();
    }

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (title, comment) VALUES ('$title', '$comment')";

    if ($conn->query($sql) === TRUE) {
        // Feedback submitted successfully, redirect to contactus.html
        header("Location: contactus.php?feedback=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
