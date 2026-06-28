<?php

// تضمين ملف الاتصال بقاعدة البيانات
include 'includes/db.php';

// متغيرات لتخزين رسائل النجاح أو الخطأ التي تظهر للمستخدم
$message = "";
$error = "";

// التحقق مما إذا كان المستخدم قد أرسل النموذج (اضغط على زر إعادة التعيين)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // استقبال البيانات القادمة من الحقول (البريد الإلكتروني وكلمة المرور الجديدة)
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    try {

        // تحضير استعلام آمن للتحقق من وجود البريد الإلكتروني في قاعدة البيانات
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        // جلب بيانات المستخدم إن وجدت
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // إذا تم العثور على البريد الإلكتروني في قاعدة البيانات
        if ($user) {

            // تشفير كلمة المرور الجديدة لحمايتها قبل حفظها
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // تحضير وتنفيذ استعلام تحديث كلمة المرور للمستخدم المعني
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);

            // نص رسالة النجاح عند اكتمال العملية
            $message = "Password updated successfully. You can login now.";

        } else {

            // رسالة خطأ في حال عدم وجود البريد الإلكتروني
            $error = "Email not found.";

        }

    } catch (PDOException $e) {

        // رسالة عامة في حال حدوث مشكلة غير متوقعة في السيرفر أو قاعدة البيانات
        $error = "Something went wrong.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>

<div class="reset-container">

    <div class="reset-box">

        <h2>Reset Password</h2>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <button type="submit">Reset Password</button>

        </form>

        <p class="success-message">
            <?php echo $message; ?>
        </p>

        <p class="error">
            <?php echo $error; ?>
        </p>

        <p class="form-link">
            Remember your password?
            <a href="login.php">Login</a>
        </p>

    </div>

</div>

</body>

</html>
