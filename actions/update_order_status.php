<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = (int) $_POST['order_id'];
    $status = $_POST['status'];
    $allowed = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

    if (in_array($status, $allowed) && $order_id > 0) {
        try {
            $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
            $stmt->execute(['status' => $status, 'order_id' => $order_id]);
        } catch (PDOException $e) {
            // Silently fail
        }
    }
}

$page = isset($_POST['page']) ? '?page=' . (int) $_POST['page'] : '';
header("Location: " . APPURL . "admin_orders.php" . $page);
exit;
