<?php
session_start();
header("Content-Type: application/json");
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "mothercare";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data['email'] ?? '');
$inputPassword = trim($data['password'] ?? '');

if (empty($email) || empty($inputPassword)) {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}

$sql = "SELECT id, firstname, lastname, password, user_type FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $firstname, $lastname, $hashed_password, $user_type);
    $stmt->fetch();

    if (password_verify($inputPassword, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['full_name'] = $firstname . ' ' . $lastname;
        $_SESSION['user_type'] = $user_type;

        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "user_type" => $user_type,
            "full_name" => $_SESSION['full_name']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Incorrect password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
