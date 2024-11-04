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

$action = $_GET['action'];

// List rooms
if ($action == 'list') {
    $result = $conn->query("SELECT * FROM rooms");
    $rooms = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rooms);

// Get a single room for editing
} elseif ($action == 'get') {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM rooms WHERE id = $id");
    echo json_encode($result->fetch_assoc());

// Add a new room
} elseif ($action == 'add') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    $conn->query("INSERT INTO rooms (name, price, description, image) VALUES ('$name', '$price', '$description', '$image')");
    echo json_encode(['success' => true]);

// Edit an existing room
} elseif ($action == 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
        $conn->query("UPDATE rooms SET name = '$name', price = '$price', description = '$description', image = '$image' WHERE id = $id");
    } else {
        $conn->query("UPDATE rooms SET name = '$name', price = '$price', description = '$description' WHERE id = $id");
    }
    
    echo json_encode(['success' => true]);

// Delete a room
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    $conn->query("DELETE FROM rooms WHERE id = $id");
    echo json_encode(['success' => true]);
}



$conn->close();
?>
