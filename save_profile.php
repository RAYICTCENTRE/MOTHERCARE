<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: screen2.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "mothercare");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$nationality = $_POST['nationality'] ?? '';
$district = $_POST['district'] ?? '';
$sub_county = $_POST['subCounty'] ?? '';
$parish = $_POST['parish'] ?? '';
$village = $_POST['village'] ?? '';
$nearest_health = $_POST['nearestHealth'] ?? '';
$kin_name = $_POST['kinName'] ?? '';
$kin_relationship = $_POST['kinRelationship'] ?? '';
$kin_contact = ($_POST['countryCode'] ?? '') . ($_POST['kinContact'] ?? '');
$dob = $_POST['dob'] ?? '';
$last_period = $_POST['lastPeriod'] ?? '';
$expected_delivery = $_POST['expectedDelivery'] ?? '';

// Prepare insert query
$stmt = $conn->prepare("INSERT INTO user_profiles 
    (user_id, nationality, district, sub_county, parish, village, nearest_health, kin_name, kin_relationship, kin_contact, dob, last_period, expected_delivery) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "issssssssssss",
    $user_id,
    $nationality,
    $district,
    $sub_county,
    $parish,
    $village,
    $nearest_health,
    $kin_name,
    $kin_relationship,
    $kin_contact,
    $dob,
    $last_period,
    $expected_delivery
);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error saving profile: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
