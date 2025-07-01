<?php
header("Content-Type: application/json");

// Show errors (optional in dev only)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "localhost";
$dbname = "mothercare";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "DB connection failed: " . $conn->connect_error]);
    exit;
}

// Get user_id from query string
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id <= 0) {
    echo json_encode(["error" => "Invalid or missing user ID."]);
    exit;
}

// Fetch user info
$user_stmt = $conn->prepare("SELECT firstname, lastname, email FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo json_encode(["error" => "User not found."]);
    exit;
}

// Fetch profile info
$profile_stmt = $conn->prepare("SELECT nationality, district, sub_county, parish, village, nearest_health, kin_name, kin_relationship, kin_contact, dob, last_period, expected_delivery, created_at FROM user_profiles WHERE user_id = ?");
$profile_stmt->bind_param("i", $user_id);
$profile_stmt->execute();
$profile_result = $profile_stmt->get_result();
$profile = $profile_result->fetch_assoc() ?? [];

// Fetch visit history
$visits_stmt = $conn->prepare("SELECT date, risk_score, risk_level FROM visits WHERE user_id = ? ORDER BY date ASC");
$visits_stmt->bind_param("i", $user_id);
$visits_stmt->execute();
$visits_result = $visits_stmt->get_result();

$visits = [];
while ($row = $visits_result->fetch_assoc()) {
    $visits[] = $row;
}

// Prepare final response
echo json_encode([
    "name" => trim($user['firstname'] . " " . $user['lastname']),
    "email" => $user['email'],
    "nationality" => $profile['nationality'] ?? 'N/A',
    "district" => $profile['district'] ?? 'N/A',
    "sub_county" => $profile['sub_county'] ?? 'N/A',
    "parish" => $profile['parish'] ?? 'N/A',
    "village" => $profile['village'] ?? 'N/A',
    "nearest_health" => $profile['nearest_health'] ?? 'N/A',
    "kin_name" => $profile['kin_name'] ?? 'N/A',
    "kin_relationship" => $profile['kin_relationship'] ?? 'N/A',
    "kin_contact" => $profile['kin_contact'] ?? 'N/A',
    "dob" => $profile['dob'] ?? 'N/A',
    "last_period" => $profile['last_period'] ?? 'N/A',
    "expected_delivery" => $profile['expected_delivery'] ?? 'N/A',
    "registered_on" => $profile['created_at'] ?? 'N/A',
    "visits" => $visits
]);


// Close connections
$user_stmt->close();
$profile_stmt->close();
$visits_stmt->close();
$conn->close();
?>
