<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if (!isset($_POST['delete-product'])) {
    header('Location: ' . APPURL . 'admin_products.php');
    exit;
}

$product_id = isset($_POST['prod_id']) ? (int) $_POST['prod_id'] : 0;
$page = isset($_POST['page']) ? max(1, (int) $_POST['page']) : 1;
$status = 'delete_error';

if ($product_id > 0) {
    try {
        $deleted = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
            ->execute([':product_id' => $product_id]);
        $status = $deleted ? 'deleted' : 'delete_error';
    } catch (Exception $e) {
        $status = 'delete_error';
    }
}

header('Location: ' . APPURL . 'admin_products.php?page=' . $page . '&status=' . $status);
exit;
