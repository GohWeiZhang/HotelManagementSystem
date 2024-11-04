<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $result = $conn->query("SELECT * FROM rooms");

    if ($result) {
        $rooms = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($rooms);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Error fetching rooms: ' . $conn->error]);
    }
}

$conn->close();
?>
