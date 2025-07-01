<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "mothercare");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['password'];

    if (empty($new_password)) {
        die("Password cannot be empty.");
    }

    // Validate token
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid or expired token.");
    }

    $reset = $result->fetch_assoc();
    $user_id = $reset['user_id'];

    // Update password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    $stmt->execute();

    // Delete used token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Password has been reset successfully. <a href='login.html'>Go to login</a>";
    exit;
}

// Display form if GET
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
</head>
<body>
  <h2>Set New Password</h2>
  <form method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label for="password">New Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>
    <button type="submit">Reset Password</button>
  </form>
</body>
</html>
