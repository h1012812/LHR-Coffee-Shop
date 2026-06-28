<?php
// ============================
// استدعاء ملف الاتصال بقاعدة البيانات
// ============================
include '../includes/db.php';

// ============================
// متغيرات لرسائل النجاح والخطأ
// ============================
$message = "";
$error   = "";

// ============================
// معالجة نموذج التسجيل عند الإرسال
// ============================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // جلب البيانات من النموذج
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // ============================
    // التحقق من تطابق كلمة المرور
    // ============================
    if ($password != $confirm) {

        $error = "Passwords do not match";

    } else {

        // ============================
        // التحقق من أن البريد غير مسجل مسبقاً
        // ============================
        $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {

            $error = "Email already exists";

        } else {

            // ============================
            // تشفير كلمة المرور قبل التخزين
            // ============================
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // ============================
            // إدخال المستخدم الجديد في قاعدة البيانات
            // ============================
            $stmt = $pdo->prepare("
                INSERT INTO users (full_name, email, password, role)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([$name, $email, $hashed, "client"]);

            // إعادة التوجيه لصفحة تسجيل الدخول
            header("Location: ../login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- ملف تنسيق صفحة التسجيل -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body>

<!-- ============================
     صفحة إنشاء حساب جديد
============================= -->
<div class="login-container">
    <div class="login-box">

        <h2>Create Account</h2>

        <!-- زر الرجوع للصفحة الرئيسية -->
        <a href="../client/index.php" class="back-home-btn">← Back to Home</a>

        <!-- ============================
             نموذج التسجيل
             يحتوي على: الاسم – البريد – كلمة المرور – تأكيد كلمة المرور
        ============================= -->
        <form method="POST" onsubmit="return validateRegister()">

            <label>Full Name</label>
            <input type="text" name="name" id="name" required>

            <label>Email</label>
            <input type="email" name="email" id="email" required>

            <label>Password</label>
            <input type="password" name="password" id="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm" required>

            <button type="submit">Register</button>
        </form>

        <!-- عرض رسالة الخطأ إن وجدت -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- رابط تسجيل الدخول -->
        <p class="form-link">
            Already have an account?
            <a href="../login.php">Login</a>
        </p>

    </div>
</div>

<!-- ملف الجافاسكربت الخاص بالتحقق -->
<script src="../assets/js/script.js"></script>

</body>
</html>
