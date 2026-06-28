<?php
include 'includes/admin_header.php';

// جلب جميع الطلبات
$orders = mysqli_query($conn,
        "SELECT o.*, u.full_name, p.name AS product_name, p.price AS product_price
     FROM orders o
     LEFT JOIN users u ON o.user_id = u.id
     LEFT JOIN products p ON o.product_id = p.id
     ORDER BY o.order_date DESC"
);
?>

<div class="admin-content">

    <h1 class="title">All Orders</h1>

    <table class="products-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
        </thead>

        <tbody>
        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>

                <td>
                    <strong><?php echo htmlspecialchars($order['full_name']); ?></strong>
                </td>

                <td>
                    <?php echo htmlspecialchars($order['product_name']); ?>
                    <br>
                    <small>SAR <?php echo $order['product_price']; ?></small>
                </td>

                <td><?php echo $order['quantity']; ?></td>

                <td><strong>SAR <?php echo $order['total_price']; ?></strong></td>

                <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</div>

<?php include 'includes/admin_footer.php'; ?>
