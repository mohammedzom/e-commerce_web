<?php
require __DIR__ . "/../config/config.php";
require __DIR__ . "/../includes/middleware/check-login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['cart_id'])) {
    $cart_item_id = isset($_POST['cart_item_id']) ? $_POST['cart_item_id'] : $_GET['cart_id'];
    $user_id = $_SESSION['user_id'];

    $cart_item = $conn->prepare("DELETE FROM cart_items WHERE cart_id = :cart_item_id AND user_id = :user_id");
    $cart_item->execute(['cart_item_id' => $cart_item_id, 'user_id' => $user_id]);
    
    header('Location: ' . APPURL . 'cart.php');
    exit;
} else {
    header('Location: ' . APPURL . 'cart.php');
    exit;
}
