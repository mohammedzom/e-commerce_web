<?php
require_once __DIR__ . '/../../config/config.php';
if (!isset($_SESSION['user_id'])) {
    setFlash('يجب تسجيل الدخول أولاً', 'warning');
    header('Location: ' . APPURL . 'auth/login.php');
    exit;
}