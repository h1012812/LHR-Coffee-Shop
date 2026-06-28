<?php
// ============================
// استدعاء الإعدادات + الهيدر المشترك للموقع
// ============================
include __DIR__ . '/../config.php';
include 'inclueds/client_header.php';

// ============================
// جلب جميع المنتجات من جدول drinks
// ============================
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!-- ============================
     صفحة القائمة (Menu Page)
     تحتوي على: عنوان – أزرار الفلترة – المنتجات
============================= -->
<section class="menu-page">

    <!-- عنوان الصفحة -->
    <div class="section-title">
        <h1>Our Menu</h1>
        <p>Fresh coffee & delicious desserts</p>
    </div>

    <!-- ============================
         أزرار الفلترة حسب التصنيف
         (All – Coffee – Dessert – Cold Drinks – Bakery)
    ============================= -->
    <div class="filter-buttons">

        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="Coffee">Coffee</button>
        <button class="filter-btn" data-filter="Dessert">Desserts</button>
        <button class="filter-btn" data-filter="Cold Drinks">Cold Drinks</button>
        <button class="filter-btn" data-filter="Bakery">Bakery</button>

    </div>

    <!-- ============================
         عرض المنتجات داخل الشبكة
    ============================= -->
    <div class="menu-container">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <!-- ============================
                 بطاقة منتج واحدة
                 تحتوي على: صورة – اسم – وصف – سعر – زر إضافة للسلة
            ============================= -->
            <div class="menu-card"
                 data-category="<?php echo $row['category']; ?>">

                <!-- صورة المنتج -->
                <img src="../assets/images/<?php echo $row['image']; ?>"
                     alt="<?php echo $row['name']; ?>">

                <div class="menu-content">

                    <!-- اسم المنتج -->
                    <h3><?php echo $row['name']; ?></h3>

                    <!-- وصف المنتج -->
                    <p><?php echo $row['description']; ?></p>

                    <div class="price-cart">

                        <!-- سعر المنتج -->
                        <span>$<?php echo $row['price']; ?></span>

                        <!-- زر إضافة للسلة (غير مفعّل حالياً) -->
                        <a href="#" class="cart-btn">Add To Cart</a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</section>

<?php
// ============================
// استدعاء الفوتر المشترك للموقع
// ============================
include 'inclueds/client_footer.php';
?>
