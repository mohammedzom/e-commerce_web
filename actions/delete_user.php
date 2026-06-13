<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_id'])) {
    $user_id = $_POST['del_id'];

    if ($user_id == $_SESSION['user_id']) {
        setFlash('لا يمكنك حذف حسابك الخاص', 'warning');
        header('Location: ' . APPURL . 'admin_users.php');
        exit;
    }

    try {
        $check_orders = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :user_id");
        $check_orders->execute(['user_id' => $user_id]);
        $has_orders = $check_orders->fetchColumn();

        if ($has_orders > 0) {
            setFlash('لا يمكن حذف المستخدم لأنه لديه طلبات سابقة', 'warning');
        } else {
            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            setFlash('تم حذف المستخدم بنجاح', 'success');
        }
    } catch (PDOException $e) {
        setFlash('حدث خطأ أثناء معالجة الطلب.', 'error');
    }
    header('Location: ' . APPURL . 'admin_users.php');
    exit;
}
