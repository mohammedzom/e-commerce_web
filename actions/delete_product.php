<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

$preveous_page = $_SERVER['HTTP_REFERER'];

if (!isset($_POST['delete-product'])) {
    header('Location: ' . $preveous_page);
    exit;
}

if (!isset($_POST['product_id']) || !isset($_POST['page'])) {
    echo "<script>alert('حدث خطأ في النظام، يرجى المحاولة مرة أخرى'); window.location.href = '" . $preveous_page . "';</script>";
    exit;
}

$product_id = (int)($_POST['product_id']);
$page = (int)($_POST['page']);
$page = max(1, $page);


try {
    $deleted = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
        ->execute([':product_id' => $product_id]);
    if ($deleted) {
        echo "<script>alert('تم حذف المنتج بنجاح'); window.location.href = '" . $preveous_page . "';</script>";
    } else {
        echo "<script>alert('فشل حذف المنتج'); window.location.href = '" . $preveous_page . "';</script>";
    }
} catch (Exception $e) {
    if ($e->getCode() == 23000) {
        echo "<script>alert('المنتج موجود في طلبات سابقة، لا يمكن حذفه'); window.location.href = '" . $preveous_page . "';</script>";
    } else {
        echo "<script>alert('فشل حذف المنتج'); window.location.href = '" . $preveous_page . "';</script>";
    }
    exit;
}
