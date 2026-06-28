<?php
// ============================
// استدعاء الإعدادات + الهيدر
// ============================
include __DIR__ . '/../config.php';
include 'inclueds/client_header.php';

// جلب المنتجات من قاعدة البيانات
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!-- ============================
     قسم الهيرو (الواجهة الرئيسية)
     يحتوي على عنوان ترحيبي + زر القائمة
============================= -->
<section class="hero" id="home">

    <div class="hero-content">
        <h1>
            Every moment made
            <span> sweeter</span>
        </h1>

        <p>
            Specialty coffee, fresh bakeries,
            and desserts made to delight.
        </p>

        <a href="#menu" class="btn">Explore Menu</a>
    </div>

</section>

<!-- ============================
     قسم المميزات الرئيسية للمقهى
============================= -->
<section class="features">

    <div class="feature-box">
        <i class="bi bi-cup-hot-fill"></i>
        <h3>Premium Coffee</h3>
        <p>Freshly brewed coffee made from high quality beans.</p>
    </div>

    <div class="feature-box">
        <i class="bi bi-cake2-fill"></i>
        <h3>Fresh Desserts</h3>
        <p>Delicious desserts and bakery made daily.</p>
    </div>

    <div class="feature-box">
        <i class="bi bi-lightning-charge-fill"></i>
        <h3>Fast Service</h3>
        <p>Quick and cozy coffee experience for everyone.</p>
    </div>

</section>

<!-- ============================
     قسم التصنيفات (Coffee - Dessert - Bakery)
============================= -->
<section class="category-section">

    <div class="category-header">
        <h2>Shop By Category</h2>
        <a href="#menu">View All →</a>
    </div>

    <div class="category-grid">

        <!-- بطاقة تصنيف القهوة -->
        <div class="category-card">
            <img src="../assets/images/category_coffee.jpg" alt="Coffee">
            <div class="overlay">
                <h3>Coffee</h3>
                <a href="#menu" onclick="filterCategory('Coffee')">Explore →</a>
            </div>
        </div>

        <!-- بطاقة تصنيف الحلويات -->
        <div class="category-card">
            <img src="../assets/images/category_dessert.jpg" alt="Dessert">
            <div class="overlay">
                <h3>Dessert</h3>
                <a href="#menu" onclick="filterCategory('Dessert')">Explore →</a>
            </div>
        </div>

        <!-- بطاقة تصنيف المخبوزات -->
        <div class="category-card">
            <img src="../assets/images/category_bakery.jpg" alt="Bakery">
            <div class="overlay">
                <h3>Bakery</h3>
                <a href="#menu" onclick="filterCategory('Bakery')">Explore →</a>
            </div>
        </div>

    </div>

</section>

<!-- ============================
     سلايدر المنتجات المميزة
============================= -->
<section class="featured-slider">
    <h2 class="slider-title">Featured Picks</h2>

    <div class="slides">

        <div class="slide active">
            <img src="../assets/images/honey_cake_slide.jpg">
            <div class="text-box">
                <h3>Honey Cake</h3>
                <p>Soft layers sweetened with natural honey.</p>
            </div>
        </div>

        <div class="slide">
            <img src="../assets/images/chocolate_cake_slide.jpg">
            <div class="text-box">
                <h3>Chocolate Cake</h3>
                <p>Rich chocolate baked to perfection.</p>
            </div>
        </div>

        <div class="slide">
            <img src="../assets/images/cheese_croissant_slide.jpg">
            <div class="text-box">
                <h3>Cheese Croissant</h3>
                <p>Flaky pastry filled with creamy cheese.</p>
            </div>
        </div>

        <div class="slide">
            <img src="../assets/images/coffee_slide.jpg">
            <div class="text-box">
                <h3>Signature Coffee</h3>
                <p>Bold, aromatic, and freshly brewed.</p>
            </div>
        </div>

    </div>
</section>

<!-- ============================
     قسم قائمة المنتجات (Menu)
============================= -->
<section class="menu-page" id="menu">

    <div class="section-title">
        <h1>Our Menu</h1>
        <p>Fresh coffee & delicious desserts</p>
    </div>

    <!-- أزرار الفلترة -->
    <div class="filter-buttons">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="Coffee">Coffee</button>
        <button class="filter-btn" data-filter="Dessert">Dessert</button>
        <button class="filter-btn" data-filter="Cold Drinks">Cold Drinks</button>
        <button class="filter-btn" data-filter="Bakery">Bakery</button>
    </div>

    <!-- عرض المنتجات -->
    <div class="menu-container">

        <?php
        // التحقق من وجود منتجات
        if ($result && mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {

                // تجهيز البيانات بشكل آمن
                $category = htmlspecialchars($row['category'] ?? 'all');
                $product_id = htmlspecialchars($row['id'] ?? '#');
                $product_name = htmlspecialchars($row['name'] ?? 'Unknown');
                $product_desc = htmlspecialchars($row['description'] ?? '');
                $product_price = htmlspecialchars($row['price'] ?? '0.00');

                // معالجة الصورة
                $image_name = !empty($row['image']) ? $row['image'] : 'default.jpg';
                ?>

                <!-- بطاقة المنتج -->
                <div class="menu-card" data-category="<?php echo $category; ?>">

                    <a href="product_details.php?id=<?php echo $product_id; ?>">
                        <img src="../assets/images/<?php echo $image_name; ?>" alt="<?php echo $product_name; ?>">
                    </a>

                    <div class="menu-content">
                        <h3><?php echo $product_name; ?></h3>
                        <p><?php echo $product_desc; ?></p>

                        <div class="price-cart">
                            <span>$<?php echo $product_price; ?></span>

                            <a href="add_to_cart.php?id=<?php echo $product_id; ?>" class="cart-btn">
                                Add To Cart
                            </a>
                        </div>
                    </div>

                </div>

                <?php
            }

        } else {
            echo "<p style='text-align:center; color:red; grid-column: 1/-1;'>No products available at the moment.</p>";
        }
        ?>

    </div>

</section>

<!-- ============================
     قسم "من نحن" (About)
============================= -->
<section class="about-banner" id="about">

    <img src="../assets/images/about.jpg" alt="About LHR Coffee">

    <div class="about-overlay">
        <h1>
            Good Coffee
            <br>
            <span>Good Mood.</span>
            <br>
            Good Life.
        </h1>

        <p>
            We believe in simple pleasures made exceptional.
            Thank you for being part of our journey.
        </p>

        <button id="storyBtn">Our Story →</button>
    </div>

</section>

<!-- نص قصة المقهى -->
<div class="our-story-content" id="ourStoryContent">
    <p>
        The story of LHR COFFEEE is a blend of warmth, passion, and the simple joy of sharing a good cup.
        From our very first brew, we dreamed of creating a place filled with aroma, comfort, and moments worth remembering.
    </p>
</div>

<!-- ============================
     قسم المعرض (Gallery)
============================= -->
<section id="gallery" class="gallery-section">

    <div class="section-title">
        <h2>Our Gallery</h2>
        <p>A glimpse of our cozy place</p>
    </div>

    <div class="gallery-container">
        <img src="../assets/images/gallery.jpg" alt="Gallery">
    </div>

</section>

<!-- ============================
     قسم آراء العملاء (Reviews)
============================= -->
<section class="reviews-section" id="reviews">

    <h2>Customer Reviews</h2>

    <div class="reviews-grid">

        <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>Amazing coffee and cozy atmosphere.</p>
            <img src="../assets/images/rev1.jpg" alt="Review 1">
            <h4>Mohammed</h4>
        </div>

        <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>Best iced latte I've ever tried.</p>
            <img src="../assets/images/rev2.jpg" alt="Review 2">
            <h4>Adam</h4>
        </div>

        <div class="review-card">
            <div class="stars">★★★★★</div>
            <p>Fresh desserts and great service.</p>
            <img src="../assets/images/rev3.jpg" alt="Review 3">
            <h4>Mona</h4>
        </div>

    </div>

</section>

<!-- ملف CSS إضافي -->
<link rel="stylesheet" href="/CoffeeShop-main/assets/css/style.css?v=5">

<?php
// ============================
// استدعاء الفوتر
// ============================
include 'inclueds/client_footer.php';
?>
