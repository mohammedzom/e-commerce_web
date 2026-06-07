<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("يجب تسجيل الدخول أولاً"); window.location.href = "' . APPURL . 'auth/login.php";</script>';
    exit;
}