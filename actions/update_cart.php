<?php
require "config/variables.php";
require "config/config.php";
require "includes/middleware/check-login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = isset($_POST['cart_id']) ? $_POST['cart_id'] : $_POST['cart_item_id'];
    $new_quantity = (int)$_POST['new_quantity'];
    $user_id = $_SESSION['user_id'];

    if ($new_quantity > 0) {
        $sql = "UPDATE cart_items SET quantity = :new_quantity WHERE cart_id = :cart_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'new_quantity' => $new_quantity,
            'cart_id' => $cart_id,
            'user_id' => $user_id
        ]);
        echo "<script>alert('تم تحديث الكمية'); window.location.href = 'cart.php';</script>";
    } else {
        // If quantity is 0, maybe remove it?
        $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id AND user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'cart_id' => $cart_id,
            'user_id' => $user_id
        ]);
        header('Location: cart.php');
    }
    exit;
} else {
    header('Location: cart.php');
    exit;
}
