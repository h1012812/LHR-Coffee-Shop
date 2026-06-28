<?php
session_start();
include '../config.php';

// إذا السلة فاضية وما في success → رجّعي المستخدم للمنيو
if (!isset($_GET['success']) && (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0)) {
    header("Location: menu.php");
    exit();
}

// حساب المجموع
$total = 0;

// عند الضغط على Place Order
if (isset($_POST['place_order'])) {

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    foreach ($_SESSION['cart'] as $product_id) {

        $q    = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
        $row  = mysqli_fetch_assoc($q);
        $price = $row['price'];

        mysqli_query($conn, "
            INSERT INTO orders (user_id, product_id, quantity, total_price, order_date)
            VALUES ('$user_id', '$product_id', 1, '$price', NOW())
        ");
    }

    unset($_SESSION['cart']);

    header("Location: checkout.php?success=1");
    exit();
}

// حساب الإجمالي
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id) {
        $q   = mysqli_query($conn, "SELECT price FROM products WHERE id=$id");
        $row = mysqli_fetch_assoc($q);
        $total += $row['price'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/checkout.css"> <!-- ملف الستايل الجديد -->
</head>

<body>

<div class="checkout-page">
    <div class="checkout-container">

        <h2 style="margin-bottom:20px;">Order Summary</h2>

        <div class="card" style="padding:25px; margin-bottom:25px;">
            <h3 style="margin-bottom:10px;">Total</h3>
            <p style="font-size:22px; font-weight:700; color:#b97f3f;">
                <?php echo $total; ?> SAR
            </p>
        </div>

        <form method="POST">
            <button type="submit" name="place_order" class="btn" style="width:100%; padding:15px;">
                Place Order
            </button>
        </form>

    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="success-popup">
    <div class="popup-card">
        <i class="bi bi-check-circle-fill"></i>
        <h3>Order Placed!</h3>
        <p>Thank you for choosing LHR Coffee ☕<br>
            Redirecting in <span id="countdown">5</span> seconds...</p>
    </div>
</div>

<script src="../assets/js/script.js"></script>

</body>
</html>
