<?php
include 'db_connect.php';

$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Database connected successfully! Tables exist.";
} else {
    echo "No tables found!";
}
$conn->close();
?>
