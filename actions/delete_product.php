<?php

require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if (isset($_POST['delete-product'])) {
    $product_id = $_POST['prod_id'];
    $statuts = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
        ->execute([':product_id' => $product_id]);
    $statuts = $statuts ? "تم حذف المنتج بنجاح" : "فشل حذف المنتج";
    echo "<script>alert('$statuts')</script>";
}
