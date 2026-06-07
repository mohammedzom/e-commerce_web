<?php


if (!isset($_SESSION['user_id'])) {
    header("Location: " . APPURL);
    exit;
}

$user = $conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
$user->execute(['user_id' => $_SESSION['user_id']]);
$user = $user->fetch(PDO::FETCH_OBJ);

if ($user->role !== 'admin') {
    include __DIR__ . '/../../errors/403.php';
    exit;
}
