<?php

function showToast(string $message, string $redirectUrl, string $type = 'info'): void
{
    $icons = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];

    $icon = $icons[$type] ?? $icons['info'];

    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $safeUrl     = htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8');
    $cssUrl      = APPURL . 'css/toast.css?v=' . time();

    echo <<<HTML
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{$cssUrl}">
</head>
<body>

<div class="toast-overlay" id="toastOverlay"></div>

<div class="toast-container" id="toastContainer">
    <div class="toast-card toast-{$type}" style="--toast-duration: 2s; position: relative;">
        <i class="bi {$icon} toast-icon"></i>
        <span class="toast-message">{$safeMessage}</span>
        <div class="toast-progress"></div>
    </div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('toastContainer').style.animation = 'toastSlideOut 0.4s ease forwards';
        document.getElementById('toastOverlay').style.animation = 'overlayOut 0.4s ease forwards';
        setTimeout(function() {
            window.location.href = '{$safeUrl}';
        }, 400);
    }, 2000);
</script>

</body>
</html>
HTML;
    exit;
}

/**
 * Show toast and go back (replaces window.history.back())
 */
function showToastBack(string $message, string $type = 'info'): void
{
    $icons = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];

    $icon = $icons[$type] ?? $icons['info'];

    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $cssUrl = APPURL . 'css/toast.css?v=' . time();

    echo <<<HTML
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{$cssUrl}">

</head>
<body>

<div class="toast-overlay" id="toastOverlay"></div>

<div class="toast-container" id="toastContainer">
    <div class="toast-card toast-{$type}" style="--toast-duration: 2s; position: relative;">
        <i class="bi {$icon} toast-icon"></i>
        <span class="toast-message">{$safeMessage}</span>
        <div class="toast-progress"></div>
    </div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('toastContainer').style.animation = 'toastSlideOut 0.4s ease forwards';
        document.getElementById('toastOverlay').style.animation = 'overlayOut 0.4s ease forwards';
        setTimeout(function() {
            window.history.back();
        }, 400);
    }, 2000);
</script>

</body>
</html>
HTML;
    exit;
}
