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

// Set response type to JSON
header('Content-Type: application/json');

// Helper function to respond with an error
function respondWithError($message) {
    echo json_encode(['error' => $message]);
    exit();
}

// Helper function for validation
function validateInput($data, $fields) {
    foreach ($fields as $field => $rules) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            return "$field is required.";
        }
        foreach ($rules as $rule => $value) {
            switch ($rule) {
                case 'type':
                    if ($value == 'numeric' && !is_numeric($data[$field])) {
                        return "$field must be numeric.";
                    }
                    break;
                case 'length':
                    if (strlen($data[$field]) > $value) {
                        return "$field must not exceed $value characters.";
                    }
                    break;
            }
        }
    }
    return null;
}

// Allowed image file types
$allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; // 2 MB

$action = $_GET['action'] ?? '';

// List rooms
if ($action === 'list') {
    $result = $conn->query("SELECT * FROM rooms");
    if ($result) {
        $rooms = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($rooms);
    } else {
        respondWithError('Failed to fetch rooms.');
    }

// Get a single room for editing
} elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        respondWithError('Invalid room ID.');
    }
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc() ?? ['error' => 'Room not found.']);

// Add a new room
} elseif ($action === 'add') {
    $fields = ['name' => ['type' => 'string', 'length' => 255], 'price' => ['type' => 'numeric'], 'description' => ['type' => 'string', 'length' => 500]];
    $error = validateInput($_POST, $fields);
    if ($error) {
        respondWithError($error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        if (!in_array($_FILES['image']['type'], $allowedFileTypes)) {
            respondWithError('Invalid file type. Only JPG, PNG, and GIF are allowed.');
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            respondWithError('File size exceeds 2 MB.');
        }
        $image = basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image)) {
            respondWithError('Failed to upload image.');
        }
    }

    $stmt = $conn->prepare("INSERT INTO rooms (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sdss', $name, $price, $description, $image);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        respondWithError('Failed to add room.');
    }

// Edit an existing room
} elseif ($action === 'edit') {
    $fields = ['id' => ['type' => 'numeric'], 'name' => ['type' => 'string', 'length' => 255], 'price' => ['type' => 'numeric'], 'description' => ['type' => 'string', 'length' => 500]];
    $error = validateInput($_POST, $fields);
    if ($error) {
        respondWithError($error);
    }

    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        if (!in_array($_FILES['image']['type'], $allowedFileTypes)) {
            respondWithError('Invalid file type. Only JPG, PNG, and GIF are allowed.');
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            respondWithError('File size exceeds 2 MB.');
        }
        $image = basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image)) {
            respondWithError('Failed to upload image.');
        }
    }

    if ($image) {
        $stmt = $conn->prepare("UPDATE rooms SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param('sdssi', $name, $price, $description, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE rooms SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->bind_param('sdsi', $name, $price, $description, $id);
    }
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        respondWithError('Failed to update room.');
    }

// Delete a room
} elseif ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        respondWithError('Invalid room ID.');
    }
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        respondWithError('Failed to delete room.');
    }

// Invalid action
} else {
    respondWithError('Invalid action.');
}

$conn->close();

?>
