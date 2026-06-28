<?php

// التحقق مما إذا كانت الجلسة (Session) لم تبدأ بعد، ليتم تشغيلها تلقائياً
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* دالة للتحقق مما إذا كان المستخدم مسجلاً للدخول أم لا */

function checkLogin(){

    // إذا لم يكن معرف المستخدم (user_id) مخزناً في الجلسة، يتم توجيهه لصفحة الدخول
    if(!isset($_SESSION['user_id'])){

        header("Location: ../login.php");

        // إنهاء تنفيذ السكريبت فوراً لمنع تحميل بقية محتويات الصفحة
        exit();
    }
}


/* دالة لحماية صفحات الإدارة ومنع العمال أو الزوار من دخولها */

function checkAdmin(){

    // استدعاء دالة فحص تسجيل الدخول أولاً للتأكد من وجود حساب
    checkLogin();

    // التحقق مما إذا كانت رتبة المستخدم (role) غير موجودة أو لا تساوي 'admin'
    if(
        !isset($_SESSION['role']) ||
        $_SESSION['role'] != 'admin'
    ){

        // إذا لم يكن مديراً، يتم توجيهه إلى الصفحة الرئيسية للعملاء
        header("Location: ../client/index.php");

        exit();
    }
}


/* دالة لحماية صفحات العملاء (المتجر) ومنع المدراء من دخولها بالخطأ */

function checkClient(){

    // استدعاء دالة فحص تسجيل الدخول أولاً
    checkLogin();

    // التحقق مما إذا كانت رتبة المستخدم (role) غير موجودة أو لا تساوي 'client'
    if(
        !isset($_SESSION['role']) ||
        $_SESSION['role'] != 'client'
    ){

        // إذا لم يكن عميلاً، يتم توجيهه تلقائياً إلى لوحة تحكم الإدارة
        header("Location: ../admin/dashboard.php");

        exit();
    }
}
?>