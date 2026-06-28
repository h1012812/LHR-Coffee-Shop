<?php

session_start();

// إذا المستخدم غير مسجل دخول
if (!isset($_SESSION['user_id'])) {

    // حفظ المنتج المطلوب إضافته بعد تسجيل الدخول
    if (isset($_GET['id'])) {
        $_SESSION['pending_product'] = $_GET['id'];
    }

    // توجيه المستخدم لصفحة تسجيل الدخول
    header("Location: ../login.php?error=login_required");
    exit();
}

include __DIR__ . '/../config.php';

// التحقق من وجود رقم المنتج
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // إنشاء السلة إذا لم تكن موجودة
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // إضافة المنتج للسلة
    $_SESSION['cart'][] = $id;

    //  لا تحويل — يبقى المستخدم في نفس الصفحة
    // فقط نرجع للخلف للصفحة السابقة
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
