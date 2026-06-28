<?php
session_start();
session_unset();
session_destroy();
header("Refresh:4; url=login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/script.js" defer></script>
</head>

<body>

<button id="theme-toggle">
    <i class="bi bi-moon-fill"></i>
</button>

<div class="logout-container">
    <div class="logout-box">
        <i class="bi bi-cup-hot-fill"></i>
        <h2>See You Soon!</h2>
        <p>You have logged out successfully.<br>Redirecting to login page...</p>
        <a href="login.php">Back to Login</a>
    </div>
</div>

</body>
</html>