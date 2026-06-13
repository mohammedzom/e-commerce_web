<?php
require __DIR__ . "/../config/config.php";
require __DIR__ . "/../includes/middleware/check-login.php";
require_once __DIR__ . "/../includes/toast.php";

$pervers_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : APPURL . 'index.php';

if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];
    $user_id = $_SESSION['user_id'];


    if (!$product_id) {
        header('Location: ' . $pervers_page);
        exit;
    }

    $product = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = :id");
    $product->execute(['id' => $product_id]);
    $product = $product->fetch(PDO::FETCH_OBJ);

    if (!$product || $product->stock_quantity <= 0) {
        showToastBack('المنتج غير متوفر حالياً', 'warning');
    }

    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['quantity'])) {
        $quantity = (int) $_POST['quantity'];
    } else {
        if ($cart_item) {
            $quantity = $cart_item->quantity + 1;
        } else {
            $quantity = 1;
        }
    }

    if ($cart_item) {

        if ($quantity > $product->stock_quantity) {
            showToastBack('الكمية المطلوبة أكثر من الكمية المتوفرة', 'warning');
        }

        $stmt = $conn->prepare("UPDATE cart_items SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['quantity' => $quantity, 'user_id' => $user_id, 'product_id' => $product_id]);

        showToast('تم تحديث الكمية في السلة', $pervers_page, 'success');
    } else {
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);

        showToast('تمت الإضافة إلى السلة', $pervers_page, 'success');
    }
} else {
    header('Location: ' . $pervers_page);
    exit;
}
