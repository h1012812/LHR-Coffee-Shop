<?php
include 'includes/admin_header.php';
include '../includes/auth.php';
checkAdmin();
include '../includes/db.php';

// COUNT PRODUCTS
$products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

// COUNT USERS
$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// COUNT ORDERS
$orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
?>

<h2 class="title">Admin Dashboard</h2>

<div class="dashboard-cards">

    <div class="card">
        <h3>Total Products</h3>
        <p><?php echo $products; ?></p>
    </div>

    <div class="card">
        <h3>Total Users</h3>
        <p><?php echo $users; ?></p>
    </div>

    <div class="card">
        <h3>Total Orders</h3>
        <p><?php echo $orders; ?></p>
    </div>

</div>

<?php include 'includes/admin_footer.php'; ?>

