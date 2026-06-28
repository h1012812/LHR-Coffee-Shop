<?php
// ============================
// استدعاء الهيدر المشترك للموقع
// ============================
include 'inclueds/client_header.php';

// ============================
// استدعاء ملف الاتصال بقاعدة البيانات
// ============================
include __DIR__ . '/../config.php';

// ============================
// التحقق من وجود رقم المنتج في الرابط
// إذا لم يوجد → إعادة التوجيه للصفحة الرئيسية
// ============================
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// تحويل رقم المنتج إلى رقم صحيح لحمايته
$id = (int)$_GET['id'];

// ============================
// جلب بيانات المنتج من قاعدة البيانات
// ============================
$query   = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($query);

// إذا لم يتم العثور على المنتج → إعادة التوجيه
if(!$product) {
    header("Location: index.php");
    exit();
}
?>

<!-- ============================
     صفحة تفاصيل المنتج (Product Details)
     تحتوي على: صورة – اسم – وصف – سعر – تقييم – سعرات – زر إضافة للسلة
============================= -->
<section class="product-details-page">

    <div class="product-wrapper">

        <!-- ============================
             صندوق صورة المنتج
        ============================= -->
        <div class="product-image-box">
            <img src="../assets/images/<?php echo $product['image']; ?>"
                 alt="<?php echo $product['name']; ?>">
        </div>

        <!-- ============================
             صندوق معلومات المنتج
        ============================= -->
        <div class="product-info-box">

            <!-- تصنيف المنتج -->
            <span class="product-category">
                <?php echo $product['category']; ?>
            </span>

            <!-- اسم المنتج -->
            <h1><?php echo $product['name']; ?></h1>

            <!-- ============================
                 تقييم المنتج (نجوم)
                 يحسب: نجوم كاملة + نصف نجمة + نجوم فارغة
            ============================= -->
            <div class="product-rating">
                <?php
                $rating   = floatval($product['rating']);
                $full     = floor($rating);                     // عدد النجوم الكاملة
                $half     = ($rating - $full) >= 0.5 ? 1 : 0;   // نصف نجمة
                $empty    = 5 - $full - $half;                  // النجوم الفارغة

                for($i = 0; $i < $full;  $i++) echo '<i class="bi bi-star-fill"></i>';
                for($i = 0; $i < $half;  $i++) echo '<i class="bi bi-star-half"></i>';
                for($i = 0; $i < $empty; $i++) echo '<i class="bi bi-star"></i>';
                ?>
                <span class="rating-num"><?php echo $rating; ?></span>
            </div>

            <!-- وصف المنتج -->
            <p class="product-desc"><?php echo $product['description']; ?></p>

            <!-- ============================
                 معلومات إضافية: السعر + السعرات
            ============================= -->
            <div class="product-meta">

                <div class="meta-item">
                    <i class="bi bi-tag-fill"></i>
                    <span><?php echo $product['price']; ?>$</span>
                </div>

                <div class="meta-item">
                    <i class="bi bi-fire"></i>
                    <span><?php echo $product['calories']; ?> kcal</span>
                </div>

            </div>

            <!-- زر إضافة المنتج إلى السلة -->
            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn">
                <i class="bi bi-cart3"></i> Add To Cart
            </a>

        </div>

    </div>

</section>



<link rel="stylesheet" href="assets/css/style.css">
<?php
// ============================
// استدعاء الفوتر المشترك للموقع
// ============================
include 'inclueds/client_footer.php';
?>
