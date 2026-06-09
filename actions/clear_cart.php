<?php
require __DIR__ . "/../config/config.php";
require __DIR__ . "/../includes/middleware/check-login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear-cart'])) {
    $user_id = $_SESSION['user_id'];

    $cart_items = $conn->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
    $cart_items->execute(['user_id' => $user_id]);

    echo "<script>alert('تم إفراغ السلة'); window.location.href = '" . APPURL . "cart.php';</script>";
    exit;
}

header('Location: ' . APPURL . 'cart.php');
exit;
