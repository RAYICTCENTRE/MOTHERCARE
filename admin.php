<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$conn = new mysqli("localhost", "root", "", "mothercare");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Collect inputs
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

if (empty($email) && empty($phone)) {
    die("Please provide email or phone number.");
}

// Lookup user
$sql = "SELECT * FROM users WHERE email = ? OR contact = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No user found with the provided credentials.");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];

// Generate secure token
$token = bin2hex(random_bytes(32));
$expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Store reset token
$stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $token, $expires_at);
$stmt->execute();

// Simulate sending link
$reset_link = "http://localhost/mothercare/forgot_password.php?token=$token";

echo "<h3>Password Reset Link</h3>";
echo "<p>Click the link below to reset your password:</p>";
echo "<a href='$reset_link'>$reset_link</a>";
?>
