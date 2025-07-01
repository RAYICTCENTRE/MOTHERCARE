<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: screen2.html');
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "mothercare";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userEmail = $_SESSION['user_email'];

// Fetch firstname from DB
$stmt = $conn->prepare("SELECT firstname FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->bind_result($firstName);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Pre-Eclampsia Guardian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #e6f7ff;
            text-align: center;
        }
        h1 {
            color: #007BFF;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 30px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
    <p>This is your dashboard.</p>

    <form method="post" action="logout.php">
        <button type="submit">Log Out</button>
    </form>
</body>
</html>
