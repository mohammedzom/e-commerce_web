<?php

require __DIR__ . "/../config/config.php";
require __DIR__ . "/../includes/middleware/check-login.php";

if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        echo "<script>alert('يرجى ملء جميع الحقول'); window.location.href = '" . APPURL . "profile.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET full_name = :name, email = :email, phone = :phone, address = :address WHERE user_id = :user_id");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'user_id' => $user_id
    ]);

    echo "<script>alert('تم تحديث الملف الشخصي بنجاح'); window.location.href = '" . APPURL . "profile.php';</script>";
    exit;
} else {
    header('Location: ' . APPURL . 'profile.php');
    exit;
}
