<?php
require_once __DIR__ . '/../../config/config.php';

require_once 'check-login.php';

if ($_SESSION['role'] !== 'admin') {
    include APPURL . 'errors/403.php';
    exit;
}
