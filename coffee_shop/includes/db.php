<?php

//  اسم الخادم
$host = "localhost";

// اسم قاعدة البيانات المراد الاتصال بها ومطابقتها لمشروع المقهى
$dbname = "coffee_shop";

// اسم المستخدم الافتراضي لخادم MySQL في  XAMPP
$username = "root";

// كلمة المرور الافتراضية لخادم MySQL في XAMPP (وضعناها فارغة)
$password = "";

try {

    // إنشاء كائن PDO جديد وبدء الاتصال بقاعدة البيانات مع دعم ترميز اللغة العربية utf8
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    // تفعيل وضع معالجة الأخطاء (Exception Mode) لإظهار التنبيهات البرمجية عند حدوث أي خلل
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

}

catch(PDOException $e){

    // في حال فشل الاتصال، يتم إيقاف السكريبت وطباعة رسالة مخصصة لحماية مسار الملفات الحقيقي
    die("Connection failed");

}
?>