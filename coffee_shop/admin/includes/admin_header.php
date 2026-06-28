<?php
require_once __DIR__ . '/../../config.php';
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="../assets/js/script.js" defer></script>
</head>

<body>

<header class="admin-header">

    <!-- Logo -->
    <a href="dashboard.php" class="admin-logo">
        <img src="../assets/images/logo.png" alt="Logo">
        <span>LHR Coffee</span>
        <span class="admin-badge">ADMIN</span>
    </a>

    <!-- Nav -->
    <nav class="admin-nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <!-- Dark Mode Toggle -->
    <button id="theme-toggle">
        <i class="bi bi-moon-fill"></i>
    </button>

</header>

<div class="admin-content">
