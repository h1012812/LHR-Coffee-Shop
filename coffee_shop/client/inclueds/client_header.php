<!DOCTYPE html>
<html lang="en">

<head>

    <!-- إعدادات أساسية للصفحة -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- عنوان الصفحة -->
    <title>LHR Coffee</title>

    <!-- خطوط Google (Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- ملف التنسيقات الرئيسي -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- أيقونات Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<!-- ============================
     HEADER
============================= -->
<header class="header">

    <!-- الشعار -->
    <a href="index.php#home" class="logo">
        <img src="../assets/images/logo.png" alt="LHR Coffee Logo">
        <span>LHR Coffee</span>
    </a>

    <!-- قائمة التنقل -->
    <nav class="navbar">
        <a href="index.php#home">Home</a>
        <a href="index.php#menu">Menu</a>
        <a href="index.php#about">About</a>
        <a href="contact.php">Contact</a>
        <a href="orders.php">Orders</a>
        <a href="#gallery">Gallery</a>
        <a href="#reviews">Reviews</a>
    </nav>

    <!-- أيقونات الهيدر -->
    <div class="header-icons">
        <a href="cart.php"><i class="bi bi-cart3"></i></a>
        <a href="register.php"><i class="bi bi-person"></i></a>

        <!-- زر تسجيل الخروج -->
        <a href="../logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>

    <!-- زر الوضع الليلي -->
    <button id="theme-toggle">
        <i class="bi bi-moon-fill"></i>
    </button>

</header>

</body>
</html>
