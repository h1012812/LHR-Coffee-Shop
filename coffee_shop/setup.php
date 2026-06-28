<?php

// ==========================================
// إعداد قاعدة البيانات وإنشاء الجداول
// ==========================================

try {

    // الاتصال بخادم الـ MySQL الرئيسي
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Connected successfully ✅</h2>";

    // إنشاء قاعدة البيانات إذا لم تكن موجودة مسبقاً
    $pdo->exec("CREATE DATABASE IF NOT EXISTS coffee_shop");
    echo "Database created successfully <br>";

    // الاتصال المباشر بقاعدة بيانات المقهى مع دعم اللغة العربية (utf8)
    $pdo = new PDO(
        "mysql:host=localhost;dbname=coffee_shop;charset=utf8",
        "root",
        ""
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ==========================================
    // جدول المستخدمين (USERS)
    // ==========================================
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users(
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100),
            email VARCHAR(100) UNIQUE,
            password VARCHAR(255),
            role ENUM('admin','client') DEFAULT 'client'
        )
    ");
    echo "Users table created successfully <br>";

    // ==========================================
    // جدول المنتجات (PRODUCTS)
    // ==========================================
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            category VARCHAR(100),
            description TEXT,
            image VARCHAR(255),
            calories INT DEFAULT 0,
            rating DECIMAL(2,1) DEFAULT 5.0,
            image2 VARCHAR(255) DEFAULT NULL
        )
    ");
    echo "Products table created successfully <br>";

    // ==========================================
    // جدول سلة التسوق (CART)
    // ==========================================
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS cart(
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            product_id INT,
            quantity INT DEFAULT 1,
            FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
        )
    ");
    echo "Cart table created successfully <br>";

    // ==========================================
    // جدول الطلبات (ORDERS)
    // ==========================================
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            product_id INT NOT NULL, 
            quantity INT NOT NULL DEFAULT 1,
            total_price DECIMAL(10,2) NOT NULL,
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            CONSTRAINT fk_orders_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    echo "Orders table created successfully <br>";

    // ==========================================
    // جدول رسائل التواصل (MESSAGES)
    // ==========================================
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Messages table created successfully <br>";

    // ==========================================
    // إدخال حساب مدير النظام (ADMIN)
    // ==========================================
    $password = password_hash("1234", PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT IGNORE INTO users (full_name, email, password, role)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        "Administrator",
        "admin@gmail.com",
        $password,
        "admin"
    ]);

    echo "Admin account inserted successfully <br>";

    // ==========================================
    // إدخال المنتجات التجريبية (SAMPLE PRODUCTS)
    // ==========================================

    // التحقق أولاً إذا كان الجدول يحتوي على منتجات مسبقاً
    $count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

    if($count == 0){

        $stmt = $pdo->prepare("
            INSERT INTO products (name, price, category, description, image, calories, rating)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        // قسم الحلويات (DESSERT)
        $stmt->execute(["Cheesecake", 28, "Dessert", "Creamy cheesecake with rich flavor.", "cheese_cake.jpg", 320, 4.8]);
        $stmt->execute(["Chocolate Cake", 30, "Dessert", "Rich chocolate layered cake.", "chocolate_cake.jpg", 410, 4.9]);
        $stmt->execute(["Tiramisu", 32, "Dessert", "Classic italian tiramisu dessert.", "tiramisu.jpg", 380, 4.7]);
        $stmt->execute(["French Toast", 24, "Dessert", "Soft toast served with syrup and cream.", "french_toast.jpg", 290, 4.8]);
        $stmt->execute(["Coconut Cake", 27, "Dessert", "Soft coconut flavored cake.", "coconut_cake.jpg", 350, 4.6]);
        $stmt->execute(["Honey Cake", 26, "Dessert", "Sweet honey layered cake.", "honey_cake.jpg", 310, 4.7]);

        // قسم المشروبات الباردة (COLD DRINKS)
        $stmt->execute(["Taro", 22, "Cold Drinks", "Creamy taro flavored iced drink.", "taro.jpg", 180, 4.8]);
        $stmt->execute(["Hibiscus Tea", 18, "Cold Drinks", "Refreshing hibiscus cold tea.", "hibiscus.jpg", 90, 4.6]);
        $stmt->execute(["Ice Tea", 16, "Cold Drinks", "Fresh cold iced tea drink.", "icetea.jpg", 70, 4.5]);
        $stmt->execute(["Mojito", 20, "Cold Drinks", "Fresh mint mojito with lemon.", "mojito.jpg", 110, 4.7]);
        $stmt->execute(["Matcha Latte", 24, "Cold Drinks", "Cold creamy japanese matcha latte.", "matcha.jpg", 200, 4.9]);

        // قسم المخبوزات (BAKERY)
        $stmt->execute(["Cookies", 14, "Bakery", "Fresh baked chocolate cookies.", "cookies.jpg", 280, 4.6]);
        $stmt->execute(["Plain Croissant", 12, "Bakery", "Classic buttery french croissant.", "plain_croissant.jpg", 240, 4.7]);
        $stmt->execute(["Chocolate Croissant", 15, "Bakery", "Croissant filled with chocolate.", "chocolate_croissant.jpg", 310, 4.8]);
        $stmt->execute(["Cheese Croissant", 15, "Bakery", "Fresh croissant with cheese filling.", "cheese_croissant.jpg", 290, 4.7]);
        $stmt->execute(["Chocolate Muffin", 16, "Bakery", "Soft muffin with chocolate flavor.", "chocolate_muffin.jpg", 350, 4.6]);
        $stmt->execute(["Strawberry Muffin", 16, "Bakery", "Fresh muffin with strawberry flavor.", "strawberry_muffin.jpg", 330, 4.7]);

        // قسم القهوة (COFFEE)
        $stmt->execute(["V60", 22, "Coffee", "Specialty brewed V60 coffee.", "v60.jpg", 15, 4.9]);
        $stmt->execute(["Americano", 14, "Coffee", "Strong espresso with hot water.", "americano.jpg", 10, 4.8]);
        $stmt->execute(["Hot Chocolate", 20, "Coffee", "Rich creamy hot chocolate drink.", "hot_chocolate.jpg", 310, 4.6]);
        $stmt->execute(["Ice Latte", 19, "Coffee", "Cold latte with smooth milk flavor.", "ice_latte.jpg", 180, 4.8]);

        echo "Sample products inserted successfully <br>";

    } else {
        echo "Sample products already exist in the database <br>";
    }

    echo "<h2>Setup completed successfully ✅</h2>";

}catch(PDOException $e){

    // عرض رسالة خطأ باللون الأحمر في حال فشل أي عملية
    echo "<span style='color:red;font-weight:bold;'>Error: " . $e->getMessage() . "</span>";

}

?>