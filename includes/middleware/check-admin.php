<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/variables.php';

require_once 'check-login.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: " . APPURL . 'errors/403.php');
    exit;
}
