<?php
require_once __DIR__ . '/../config/config.php';

function jsonResponse(array $payload, int $status = 200): void
{
  http_response_code($status);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($payload, JSON_UNESCAPED_UNICODE);
  exit;
}

function messageCounts(PDO $conn): array
{
  return [
    'total' => (int) $conn->query("SELECT COUNT(*) FROM contacts")->fetchColumn(),
    'unread' => (int) $conn->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn(),
  ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . APPURL . 'admin_messages.php');
  exit;
}

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
  jsonResponse(['success' => false, 'message' => 'غير مصرح بتنفيذ هذه العملية.'], 403);
}

$action = $_POST['ajax_action'] ?? '';
$ids = array_values(array_unique(array_filter(array_map('intval', $_POST['ids'] ?? []), function ($id) {
  return $id > 0;
})));

try {
  if ($action === 'mark_read') {
    if (count($ids) === 0) {
      jsonResponse(['success' => false, 'message' => 'لم يتم تحديد أي رسائل.'], 422);
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("UPDATE contacts SET is_read = 1 WHERE ` message_id` IN ($placeholders)");
    $stmt->execute($ids);

    jsonResponse([
      'success' => true,
      'counts' => messageCounts($conn),
    ]);
  }

  if ($action === 'mark_all_read') {
    $conn->exec("UPDATE contacts SET is_read = 1 WHERE is_read = 0");

    jsonResponse([
      'success' => true,
      'counts' => messageCounts($conn),
    ]);
  }

  if ($action === 'delete') {
    if (count($ids) === 0) {
      jsonResponse(['success' => false, 'message' => 'لم يتم تحديد أي رسائل.'], 422);
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("DELETE FROM contacts WHERE ` message_id` IN ($placeholders)");
    $stmt->execute($ids);

    jsonResponse([
      'success' => true,
      'counts' => messageCounts($conn),
    ]);
  }

  jsonResponse(['success' => false, 'message' => 'إجراء غير معروف.'], 400);
} catch (PDOException $e) {
  error_log('Admin messages action failed: ' . $e->getMessage());
  jsonResponse(['success' => false, 'message' => 'تعذر تنفيذ العملية الآن.'], 500);
}
