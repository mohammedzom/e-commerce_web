<?php
require "../config/config.php";
require "../includes/middleware/check-login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // 1. Calculate total from cart items
    $cart_items = $conn->prepare("SELECT c.*, p.price FROM cart_items c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = :user_id");
    $cart_items->execute(['user_id' => $user_id]);
    $items = $cart_items->fetchAll(PDO::FETCH_OBJ);

    if (count($items) === 0) {
        header('Location: cart.php');
        exit;
    }

    $total = 0;
    foreach ($items as $item) {
        $total += $item->price * $item->quantity;
    }

    $total += $total * 0.01;

    $user_stmt = $conn->prepare("SELECT address FROM users WHERE user_id = :user_id");
    $user_stmt->execute(['user_id' => $user_id]);
    $user = $user_stmt->fetch(PDO::FETCH_OBJ);
    $shipping_address = $user->address;

    try {
        $conn->beginTransaction();

        $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address) VALUES (:user_id, :total, :address)");
        $order_stmt->execute([
            'user_id' => $user_id,
            'total' => $total,
            'address' => $shipping_address
        ]);
        $order_id = $conn->lastInsertId();

        $order_item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (:order_id, :product_id, :qty, :price)");

        $update_stock = $conn->prepare("UPDATE products SET stock_quantity = stock_quantity - :qty WHERE product_id = :product_id");

        foreach ($items as $item) {
            $order_item_stmt->execute([
                'order_id' => $order_id,
                'product_id' => $item->product_id,
                'qty' => $item->quantity,
                'price' => $item->price
            ]);

            $update_stock->execute([
                'qty' => $item->quantity,
                'product_id' => $item->product_id
            ]);
        }

        $conn->prepare("DELETE FROM cart_items WHERE user_id = :user_id")->execute(['user_id' => $user_id]);

        $conn->commit();
        echo "<script>alert('تم تأكيد الطلب بنجاح!'); window.location.href = '" . APPURL . "order_history.php';</script>";
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "<script>alert('حدث خطأ أثناء معالجة الطلب'); window.location.href = '" . APPURL . "cart.php';</script>";
        exit;
    }
} else {
    header('Location: cart.php');
    exit;
}
