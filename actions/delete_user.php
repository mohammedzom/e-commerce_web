<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_id'])) {
    $user_id = $_POST['del_id'];

    if ($user_id == $_SESSION['user_id']) {
        echo '<script>alert("لا يمكنك حذف حسابك الخاص"); window.location.href = "' . APPURL . 'admin_users.php"; exit;</script>';
    }

    try {
        $check_orders = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :user_id");
        $check_orders->execute(['user_id' => $user_id]);
        $has_orders = $check_orders->fetchColumn();

        if ($has_orders > 0) {
            echo '<script>alert("لا يمكن حذف المستخدم لأنه لديه طلبات سابقة"); window.location.href = "' . APPURL . 'admin_users.php"; exit;</script>';
        } else {
            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            echo '<script>alert("تم حذف المستخدم بنجاح"); window.location.href = "' . APPURL . 'admin_users.php"; exit;</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("حدث خطأ أثناء معالجة الطلب."); window.location.href = "' . APPURL . 'admin_users.php"; exit;</script>';
    }
}
