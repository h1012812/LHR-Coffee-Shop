<?php

// تضمين ملف الاتصال بقاعدة البيانات
include 'includes/db.php';

// بدء الجلسة لتخزين بيانات المستخدم بعد تسجيل الدخول
session_start();

// متغير لتخزين رسائل الخطأ في حال فشل تسجيل الدخول
$error = "";

// التحقق مما إذا كان المستخدم قد أرسل النموذج (اضغط على زر الدخول)
if ($_SERVER["REQUEST_METHOD"]=="POST") {

    // استقبال البيانات القادمة من الحقول
    $email = $_POST['email'];
    $password = $_POST['password'];

    try{

        // تحضير استعلام آمن للبحث عن المستخدم بواسطة البريد الإلكتروني
        $stmt = $pdo->prepare(
                "SELECT * FROM users WHERE email=?"
        );

        // تنفيذ الاستعلام وتمرير البريد الإلكتروني
        $stmt->execute([$email]);

        // جلب بيانات المستخدم على شكل مصفوفة ترابطية
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        // التحقق من وجود المستخدم، ومن صحة كلمة المرور المشفرة
        if($user && password_verify($password,$user['password'])){

            // تخزين بيانات المستخدم داخل الجلسة لاستخدامها في بقية الصفحات
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['full_name'];


            // إذا كان هناك منتج محفوظ قبل تسجيل الدخول
            if (isset($_SESSION['pending_product'])) {

                // إنشاء السلة إذا لم تكن موجودة مسبقاً
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // إضافة المنتج للسلة
                $_SESSION['cart'][] = $_SESSION['pending_product'];

                // حذف القيمة بعد استخدامها
                unset($_SESSION['pending_product']);

                // يرجع المستخدم لنفس الصفحة اللي كان فيها قبل تسجيل الدخول
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);}
                exit();
            }





            // توجيه المستخدم حسب صلاحيته (مدير نظام أم عميل)
            if($user['role']=="admin"){
                // التوجيه إلى لوحة تحكم الإدارة
                header("Location: admin/dashboard.php");
            }
            else{
                // التوجيه إلى الصفحة الرئيسية للعميل
                header("Location: client/index.php");
            }

            // إنهاء السكريبت بعد التوجيه فوراً
            exit();

        }

        else{
            // رسالة خطأ بالإنجليزية في حال كانت البيانات غير مطابقة
            $error = "Invalid email or password";
        }

    }

    catch(PDOException $e){
        // رسالة عامة في حال حدوث مشكلة غير متوقعة في قاعدة البيانات
        $error = "Something went wrong";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <h2>Login</h2>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

        </form>

        <p class="error">
            <?php echo $error; ?>
        </p>

        <p class="form-link">
            <a href="reset_password.php">Forgot Password?</a>
        </p>

        <p class="form-link">
            Don't have an account?
            <a href="client/register.php">Register</a>
        </p>

    </div>

</div>





<script src="assets/js/script.js"></script></body>

</html>

