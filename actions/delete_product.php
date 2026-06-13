<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';
require_once __DIR__ . '/../includes/toast.php';

$preveous_page = $_SERVER['HTTP_REFERER'];

if (!isset($_POST['delete-product'])) {
    header('Location: ' . $preveous_page);
    exit;
}

if (!isset($_POST['product_id']) || !isset($_POST['page'])) {
    showToast('حدث خطأ في النظام، يرجى المحاولة مرة أخرى', $preveous_page, 'error');
}

$product_id = (int)($_POST['product_id']);
$page = (int)($_POST['page']);
$page = max(1, $page);


try {
    $deleted = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
        ->execute([':product_id' => $product_id]);
    if ($deleted) {
        showToast('تم حذف المنتج بنجاح', $preveous_page, 'success');
    } else {
        showToast('فشل حذف المنتج', $preveous_page, 'error');
    }
} catch (Exception $e) {
    if ($e->getCode() == 23000) {
        showToast('المنتج موجود في طلبات سابقة، لا يمكن حذفه', $preveous_page, 'warning');
    } else {
        showToast('فشل حذف المنتج', $preveous_page, 'error');
    }
}
