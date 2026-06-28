<?php

// بدء الجلسة لاستخدام السلة
session_start();

// استدعاء الاتصال بقاعدة البيانات + الهيدر
include __DIR__ . '/../config.php';
include 'inclueds/client_header.php';

?>

<!-- ============================
     صفحة السلة (Cart Page)
     تعرض المنتجات المضافة + الإجمالي
============================= -->
<section class="cart-page">

    <!-- عنوان الصفحة -->
    <div class="cart-header">
        <h1>Your Cart</h1>
        <p>Your favorite coffee is waiting ☕</p>
    </div>

    <div class="cart-container">

        <?php
        // إجمالي السعر
        $total = 0;

        // التحقق من وجود عناصر في السلة
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

            foreach ($_SESSION['cart'] as $id) {

                // تأمين رقم المنتج
                $id = (int)$id;

                // جلب بيانات المنتج من قاعدة البيانات
                $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
                $row = mysqli_fetch_assoc($query);

                // التحقق من وجود المنتج فعلياً
                if ($row) {

                    // إضافة السعر إلى الإجمالي
                    $total += $row['price'];

                    // معالجة الصورة في حال كانت فارغة
                    $image_name = (!empty($row['image'])) ? $row['image'] : 'default.jpg';
                    ?>

                    <!-- بطاقة المنتج داخل السلة -->
                    <div class="cart-card">

                        <!-- صورة المنتج -->
                        <div class="cart-image">
                            <img src="../assets/images/<?php echo $image_name; ?>"
                                 alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>

                        <!-- معلومات المنتج -->
                        <div class="cart-info">
                            <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>

                            <span class="cart-category">
                                <?php echo htmlspecialchars($row['category']); ?>
                            </span>
                        </div>

                        <!-- السعر + زر الإزالة -->
                        <div class="cart-price">
                            <h3>$<?php echo htmlspecialchars($row['price']); ?></h3>

                            <a href="remove_cart.php?id=<?php echo $id; ?>" class="remove-btn">
                                Remove
                            </a>
                        </div>

                    </div>

                    <?php
                }
            }

        } else {
            echo "<h2>Your Cart Is Empty</h2>";
        }
        ?>

    </div>

    <!-- ============================
         إجمالي السلة + زر الدفع
    ============================= -->
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>

        <div class="cart-total">
            <h2>Total: $<?php echo $total; ?></h2>

            <a href="checkout.php" class="checkout-btn">
                Proceed To Checkout
            </a>
        </div>

    <?php } ?>

</section>

<?php
// استدعاء الفوتر
include 'inclueds/client_footer.php';
?>
