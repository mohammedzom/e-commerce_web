<?php
function setFlash(string $message, string $type = 'info'): void
{
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function displayFlash(): string
{
    if (!isset($_SESSION['flash_message'])) return "";

    $message = htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8');
    $type = $_SESSION['flash_type'] ?? 'info';

    unset($_SESSION['flash_message'], $_SESSION['flash_type']);

    $icons = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];
    $icon = $icons[$type] ?? $icons['info'];

    return '<div class="flash-msg flash-' . $type . '">' .
        '  <i class="bi ' . $icon . '"></i>' .
        '  <span>' . $message . '</span>' .
        '</div>';
}
