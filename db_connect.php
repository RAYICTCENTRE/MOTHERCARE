<?php
$servername = "localhost";
$username = "root"; // Default username in XAMPP
$password = ""; // Default is empty
$dbname = "preeclampsia_guardian";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
