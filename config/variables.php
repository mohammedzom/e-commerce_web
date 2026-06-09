<?php
$env_file = __DIR__ . '/../.env';

if (file_exists($env_file)) {
    $lines = file($env_file);
    foreach ($lines as $line) {
        if (trim($line) !== '' && $line[0] !== '#') {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            $value = trim($value, "'\"");
            putenv("$key=$value");
        }
    }
}

$appUrl = getenv('APPURL');
if (!$appUrl) $appUrl = 'http://localhost/E-Commerce/';
define('APPURL', $appUrl);

$isproduction = getenv('APP_ENV') === 'production';
$isdevelopment = getenv('APP_ENV') === 'development';
define('isProduction', $isproduction);
define('isDevelopment', $isdevelopment);

$status_map = [
    'pending' => [
        'class' => 'status-pending',
        'icon' => 'bi-clock-fill',
        'label' => 'قيد الانتظار'
    ],
    'paid' => [
        'class' => 'status-processing',
        'icon' => 'bi-credit-card-fill',
        'label' => 'مدفوع'
    ],
    'shipped' => [
        'class' => 'status-shipped',
        'icon' => 'bi-truck',
        'label' => 'تم الشحن'
    ],
    'delivered' => [
        'class' => 'status-completed',
        'icon' => 'bi-check-circle-fill',
        'label' => 'تم التوصيل'
    ],
    'cancelled' => [
        'class' => 'status-cancelled',
        'icon' => 'bi-x-circle-fill',
        'label' => 'ملغي'
    ],
];
