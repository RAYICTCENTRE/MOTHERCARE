<?php
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: screen2.html");
    exit;
}

// Get session data
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'] ?? "User";

// Optionally check profile completion (use DB check here if needed)
$profileComplete = true; // Set this from DB if dynamic
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MotherCare – Dashboard</title>
  <style>
    :root {
      --primary: #6a1b9a;
      --secondary: #3949ab;
      --hover: #303f9f;
      --bg: #f3f6f9;
      --white: #ffffff;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--bg);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      width: 90%;
      max-width: 500px;
      background-color: var(--white);
      padding: 40px 25px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    h1 {
      font-size: 1.7rem;
      color: var(--primary);
      margin-bottom: 25px;
    }
    a.dashboard-btn, button.dashboard-btn {
      display: block;
      width: 100%;
      padding: 16px;
      margin: 12px 0;
      border-radius: 10px;
      font-size: 1.05rem;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      border: none;
      color: white;
      background-color: var(--secondary);
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    a.dashboard-btn:hover:not(:disabled),
    button.dashboard-btn:hover:not(:disabled) {
      background-color: var(--hover);
    }
    button.dashboard-btn:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
      color: #666666;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Welcome, <?php echo strtoupper(htmlspecialchars($full_name)); ?>!</h1>

    <a href="screen4.html" class="dashboard-btn" id="btn-profile">Set Up Your Profile</a>
    <button class="dashboard-btn" id="btn-symptoms">Check Symptoms</button>
    <button class="dashboard-btn" id="btn-history">Visit History</button>
    <a href="screen1.html" class="dashboard-btn" id="btn-logout">Logout</a>
  </div>

  <script>
    const profileComplete = <?php echo $profileComplete ? 'true' : 'false'; ?>;
    const userId = <?php echo json_encode($user_id); ?>;

    if (!profileComplete) {
      document.getElementById("btn-symptoms").disabled = true;
      document.getElementById("btn-history").disabled = true;
    }

    document.getElementById("btn-symptoms").addEventListener("click", () => {
      if (!document.getElementById("btn-symptoms").disabled) {
        window.location.href = "screen6.html";
      }
    });

    document.getElementById("btn-history").addEventListener("click", () => {
      if (!document.getElementById("btn-history").disabled) {
      window.location.href = `VisitSummary.html?user_id=${encodeURIComponent(userId)}`;


      }
    });
  </script>

</body>
</html>
