<?php 
require_once __DIR__ . '/../config/config.php';

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
setFlash('تم إرسال رسالتك بنجاح', 'success');
header('Location: ' . APPURL . 'contact.php');
exit;
} catch (PDOException $e) {
    setFlash('حدث خطأ يرجى المحاولة مرة أخرى', 'error');
    header('Location: ' . APPURL . 'contact.php');
    exit;
}
