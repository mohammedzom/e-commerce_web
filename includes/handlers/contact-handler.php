<?php 
require_once '../header.php';
require_once '../../config/config.php';

if(!isset($_POST['send'])) {
    header("Location: ../../index.php");
    exit;
}

try {
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
$stmt->execute([
  'name' => $name,
  'email' => $email,
  'subject' => $subject,
  'message' => $message
]);
echo '<script>alert("تم إرسال رسالتك بنجاح"); window.location.href = "' . APPURL . '/contact.php";</script>';


exit;
} catch (PDOException $e) {
    echo '<script>alert("حدث خطأ يرجى المحاولة مرة أخرى"); window.location.href = "' . APPURL . '/contact.php";</script>';
    exit;
}
