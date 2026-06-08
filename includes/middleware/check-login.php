<?php
require_once __DIR__ . '/../../config/config.php';
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("يجب تسجيل الدخول أولاً"); window.location.href = "' . APPURL . 'auth/login.php";</script>';
    exit;
}