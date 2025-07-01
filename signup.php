<?php
// signup.php

// Connect to database
$conn = new mysqli("localhost", "root", "", "mothercare");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize inputs
$firstname = $conn->real_escape_string($_POST['first_name'] ?? '');
$lastname = $conn->real_escape_string($_POST['last_name'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$contact = $conn->real_escape_string($_POST['contact'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$user_type = $conn->real_escape_string($_POST['user_type'] ?? 'Client'); // Default fallback to 'Client'

if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password) || empty($user_type)) {
    echo "All fields are required.";
    exit();
}

if ($password !== $confirm_password) {
    echo "Passwords do not match.";
    exit();
}

// Check if user already exists
$check = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($check->num_rows > 0) {
    echo "This email is already registered.";
    exit();
}

// Hash password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// ✅ Insert user_type into the database too
$sql = "INSERT INTO users (firstname, lastname, email, password, user_type, created_at) 
        VALUES ('$firstname', '$lastname', '$email', '$hashed_password', '$user_type', NOW())";

if ($conn->query($sql)) {
    header("Location: screen2.html");
    exit();
} else {
    echo "Signup failed: " . $conn->error;
}

$conn->close();
?>
