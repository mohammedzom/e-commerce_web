<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../toast.php';
if (!isset($_SESSION['user_id'])) {
    showToast('يجب تسجيل الدخول أولاً', APPURL . 'auth/login.php', 'warning');
}