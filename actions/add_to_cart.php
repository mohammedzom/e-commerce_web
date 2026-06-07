<?php
require "config/variables.php";
require "config/config.php";
require "includes/middleware/check-login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['product_id'])) {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : $_GET['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $user_id = $_SESSION['user_id'];

    if (!$product_id) {
        header('Location: index.php');
        exit;
    }

    $product = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = :id");
    $product->execute(['id' => $product_id]);
    $product = $product->fetch(PDO::FETCH_OBJ);
    
    if (!$product || $product->stock_quantity <= 0) {
        echo "<script>alert('المنتج غير متوفر حالياً'); window.history.back();</script>";
        exit;
    }

    $cart_item = $conn->prepare("SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
    $cart_item->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $existing = $cart_item->fetch(PDO::FETCH_OBJ);

    if ($existing) {
        // PDF says update if exists
        $new_qty = $existing->quantity + $quantity;
        if ($new_qty > $product->stock_quantity) $new_qty = $product->stock_quantity;
        
        $conn->prepare("UPDATE cart_items SET quantity = :qty WHERE user_id = :user_id AND product_id = :product_id")
             ->execute(['qty' => $new_qty, 'user_id' => $user_id, 'product_id' => $product_id]);
             
        echo "<script>alert('تم تحديث الكمية في السلة'); window.location.href = 'cart.php';</script>";
        exit;
    } else {
        $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)")
             ->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);

        echo "<script>alert('تمت الإضافة إلى السلة'); window.location.href = 'cart.php';</script>";
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
