<?php 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/toast.php';

if(!isset($_POST['send'])) {
    header("Location: " . APPURL . "index.php");
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
showToast('تم إرسال رسالتك بنجاح', APPURL . 'contact.php', 'success');
} catch (PDOException $e) {
    showToast('حدث خطأ يرجى المحاولة مرة أخرى', APPURL . 'contact.php', 'error');
}
