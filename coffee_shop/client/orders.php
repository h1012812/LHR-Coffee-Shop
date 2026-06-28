<?php
session_start();
include __DIR__ . '/../config.php';
include 'inclueds/client_header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

// نجلب كل الطلبات الخاصة بالمستخدم
$orders = mysqli_query($conn,
        "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC"
);
?>

<section class="orders-page">

    <div class="section-title">
        <h2>My Orders</h2>
        <p>Track all your previous orders</p>
    </div>

    <div class="orders-container">

        <?php if (mysqli_num_rows($orders) > 0): ?>

            <?php while ($order = mysqli_fetch_assoc($orders)): ?>

                <?php
                // نجلب بيانات المنتج
                $product_id = (int)$order['product_id'];
                $product = mysqli_query($conn,
                        "SELECT name, price FROM products WHERE id = $product_id"
                );
                $prod = mysqli_fetch_assoc($product);
                ?>

                <div class="order-card">

                    <div class="order-card-header">
                        <div>
                            <h3>Order #<?php echo $order['id']; ?></h3>
                            <span class="order-date">
                                <?php echo date('d M Y — h:i A', strtotime($order['order_date'])); ?>
                            </span>
                        </div>
                    </div>

                    <div class="order-items-list">
                        <div class="order-item">
                            <span><?php echo htmlspecialchars($prod['name']); ?></span>
                            <span>$ <?php echo $prod['price']; ?></span>
                        </div>
                    </div>

                    <div class="order-card-footer">
                        <span>Quantity: <strong><?php echo $order['quantity']; ?></strong></span>
                        <span>Total: <strong>$ <?php echo $order['total_price']; ?></strong></span>
                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>
            <div class="no-orders">
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="index.php#menu" class="btn" style="margin-top:20px;display:inline-block;">
                    Browse Menu
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include 'inclueds/client_footer.php'; ?>
