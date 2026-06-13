<?php
/**
 * Session-based Flash Messages
 */

function setFlash(string $message, string $type = 'info'): void
{
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function displayFlash(): void
{
    if (!isset($_SESSION['flash_message'])) return;

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

    echo '<div class="flash-msg flash-' . $type . '">';
    echo '  <i class="bi ' . $icon . '"></i>';
    echo '  <span>' . $message . '</span>';
    echo '</div>';
}
