<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

$preveous_page = $_SERVER['HTTP_REFERER'];

if (!isset($_POST['delete-product'])) {
    header('Location: ' . $preveous_page);
    exit;
}

if (!isset($_POST['product_id']) || !isset($_POST['page'])) {
    setFlash('حدث خطأ في النظام، يرجى المحاولة مرة أخرى', 'error');
    header('Location: ' . $preveous_page);
    exit;
}

$product_id = (int)($_POST['product_id']);
$page = (int)($_POST['page']);
$page = max(1, $page);


try {
    $deleted = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
        ->execute([':product_id' => $product_id]);
    if ($deleted) {
        setFlash('تم حذف المنتج بنجاح', 'success');
    } else {
        setFlash('فشل حذف المنتج', 'error');
    }
    header('Location: ' . $preveous_page);
    exit;
} catch (Exception $e) {
    if ($e->getCode() == 23000) {
        setFlash('المنتج موجود في طلبات سابقة، لا يمكن حذفه', 'warning');
    } else {
        setFlash('فشل حذف المنتج', 'error');
    }
    header('Location: ' . $preveous_page);
    exit;
}
