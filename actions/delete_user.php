<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';
require_once __DIR__ . '/../includes/toast.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del_id'])) {
    $user_id = $_POST['del_id'];

    if ($user_id == $_SESSION['user_id']) {
        showToast('لا يمكنك حذف حسابك الخاص', APPURL . 'admin_users.php', 'warning');
    }

    try {
        $check_orders = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :user_id");
        $check_orders->execute(['user_id' => $user_id]);
        $has_orders = $check_orders->fetchColumn();

        if ($has_orders > 0) {
            showToast('لا يمكن حذف المستخدم لأنه لديه طلبات سابقة', APPURL . 'admin_users.php', 'warning');
        } else {
            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            showToast('تم حذف المستخدم بنجاح', APPURL . 'admin_users.php', 'success');
        }
    } catch (PDOException $e) {
        showToast('حدث خطأ أثناء معالجة الطلب.', APPURL . 'admin_users.php', 'error');
    }
}
