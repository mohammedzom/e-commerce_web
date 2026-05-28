<?php


if (isset($_SESSION['user_id'])) {
    $user = $conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
    $user->execute(['user_id' => $_SESSION['user_id']]);
    $user = $user->fetch(PDO::FETCH_OBJ);

    if ($user->role !== 'admin') {
        header("Location: " . APPURL);
        exit;
    }
} else {
    header("Location: " . APPURL);
    exit;
}
