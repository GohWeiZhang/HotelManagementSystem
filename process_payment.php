<?php
session_start();

// Database connection settings
$servername = getenv('DB_SERVER') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'user';

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit();
}

// Define constants for rate limiting
$limit = 2; // Number of allowed attempts
$timeFrame = 30; // Time frame in seconds

// Initialize session variables if not set
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['first_attempt_time'] = time();
}

// Check if the time frame has passed
if (time() - $_SESSION['first_attempt_time'] < $timeFrame) {
    if ($_SESSION['attempts'] >= $limit) {
        echo json_encode(['success' => false, 'error' => 'Rate limit exceeded. Please try again later.']);
        exit();
    }
} else {
    // Reset the counter after the time frame has passed
    $_SESSION['attempts'] = 0;
    $_SESSION['first_attempt_time'] = time();
}

// Increment the attempts counter
$_SESSION['attempts']++;

// Function to sanitize inputs
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// AES-128-CTR Encryption
function encrypt($plaintext, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-ctr'));
    $ciphertext = openssl_encrypt($plaintext, 'aes-128-ctr', $key, 0, $iv);
    return base64_encode($iv . $ciphertext); // Return IV + Ciphertext
}

function decrypt($ciphertext, $key) {
    $ciphertext = base64_decode($ciphertext);
    $iv_length = openssl_cipher_iv_length('aes-128-ctr');
    $iv = substr($ciphertext, 0, $iv_length);
    $ciphertext = substr($ciphertext, $iv_length);
    return openssl_decrypt($ciphertext, 'aes-128-ctr', $key, 0, $iv);
}

// Retrieve and sanitize form data
$roomName = sanitizeInput($_POST['room_name'] ?? '');
$checkinDate = sanitizeInput($_POST['checkin_date'] ?? '');
$checkoutDate = sanitizeInput($_POST['checkout_date'] ?? '');
$totalPrice = floatval($_POST['total_price'] ?? 0);
$userName = sanitizeInput($_POST['user_name'] ?? '');
$userEmail = sanitizeInput($_POST['user_email'] ?? '');
$userPhone = sanitizeInput($_POST['user_phone'] ?? '');
$creditCardNumber = sanitizeInput($_POST['card_number'] ?? '');
$nameOnCard = sanitizeInput($_POST['name_on_card'] ?? '');
$expiryDate = sanitizeInput($_POST['expiry_date'] ?? '');
$bookingID = sanitizeInput($_POST['booking_id'] ?? '');
$numberOfPeople = intval($_POST['number_of_people'] ?? 0); // Use intval for numeric values

// Check if the name on the card contains numbers
if (preg_match('/\d/', $nameOnCard)) {
    echo json_encode(['success' => false, 'error' => 'Payment failed: Name on card cannot contain numbers.']);
    exit();
}

// Check for required fields
if (empty($creditCardNumber) || empty($nameOnCard) || empty($expiryDate) || empty($userName) || empty($userEmail)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit();
}

// Encrypt the credit card number
$key = '1234567890123456'; // 128-bit key (16 bytes) - Ensure this is kept secure
$encryptedCreditCardNumber = encrypt($creditCardNumber, $key);

// Prepare and execute the query to insert booking information
$stmt = $conn->prepare("INSERT INTO bookings (room_name, checkin_date, checkout_date, total_price, user_name, user_email, user_phone, card_number, name_on_card, expiry_date, booking_id, number_of_people) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sssssssssssd", $roomName, $checkinDate, $checkoutDate, $totalPrice, $userName, $userEmail, $userPhone, $encryptedCreditCardNumber, $nameOnCard, $expiryDate, $bookingID, $numberOfPeople);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        error_log('Error during insertion: ' . $stmt->error);
        echo json_encode(['success' => false, 'error' => 'Failed to insert booking.']);
    }
    $stmt->close();
} else {
    error_log('Prepare statement failed: ' . $conn->error);
    echo json_encode(['success' => false, 'error' => 'Internal error occurred.']);
}

// Close the database connection
$conn->close();
?>
