<?php

/**
 * Toast Notification Helper
 * 
 * Replaces ugly JavaScript alert() with beautiful toast notifications.
 * 
 * Types: 'success', 'error', 'warning', 'info'
 */

function showToast(string $message, string $redirectUrl, string $type = 'info'): void
{
    $icons = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];

    $icon = $icons[$type] ?? $icons['info'];

    // Escape for safe HTML output
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $safeUrl     = htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8');

    echo <<<HTML
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

*{margin:0;padding:0;box-sizing:border-box}

body {
    font-family: 'Cairo', sans-serif;
    direction: rtl;
    background: transparent;
}

.toast-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 99998;
    animation: overlayIn 0.3s ease;
}

@keyframes overlayIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes overlayOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

.toast-container {
    position: fixed;
    top: 32px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 99999;
    animation: toastSlideIn 0.5s cubic-bezier(0.21, 1.02, 0.73, 1) forwards;
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0) scale(1);
    }
}

@keyframes toastSlideOut {
    from {
        opacity: 1;
        transform: translateX(-50%) translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateX(-50%) translateY(-20px) scale(0.95);
    }
}

.toast-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 28px;
    min-width: 320px;
    max-width: 480px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 14px;
    border-right: 4px solid var(--toast-color);
}

.toast-card .toast-icon {
    font-size: 1.6rem;
    color: var(--toast-color);
    flex-shrink: 0;
}

.toast-card .toast-message {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2D3436;
    line-height: 1.6;
    flex: 1;
}

.toast-progress {
    position: absolute;
    bottom: 0;
    right: 0;
    height: 3px;
    background: var(--toast-color);
    border-radius: 0 0 14px 14px;
    animation: progressShrink var(--toast-duration) linear forwards;
}

@keyframes progressShrink {
    from { width: 100%; }
    to { width: 0%; }
}

/* Type-specific colors */
.toast-success { --toast-color: #81C995; }
.toast-error   { --toast-color: #E07A7A; }
.toast-warning { --toast-color: #F0C75E; }
.toast-info    { --toast-color: #6AADCF; }
</style>
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

    echo <<<HTML
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?php echo APPURL . 'css/toast.css?v=' . time(); ?>">

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
