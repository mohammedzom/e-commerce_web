<?php
require_once '../config/config.php';
require_once '../includes/middleware/check-admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = (int) $_POST['user_id'];
    $role = $_POST['role'];

    if (!in_array($role, ['customer', 'admin'])) {
        header("Location: " . APPURL . "admin_users.php");
        exit;
    }

    if ($user_id == $_SESSION['user_id']) {
        header("Location: " . APPURL . "admin_users.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE users SET role = :role WHERE user_id = :user_id");
        $stmt->execute(['role' => $role, 'user_id' => $user_id]);
    } catch (PDOException $e) {
        // Silently fail
    }
}

header("Location: " . APPURL . "admin_users.php");
exit;
