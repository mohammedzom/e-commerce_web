<?php
$page_description = 'إدارة الرسائل — عرض وإدارة رسائل الزوار والعملاء.';
$page_title = 'إدارة الرسائل';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $msg_id = (int)($_POST['message_id'] ?? 0);

  if ($msg_id > 0) {
    if ($action === 'mark_read') {
      $stmt = $conn->prepare("UPDATE contacts SET is_read = 1 WHERE message_id = ?");
      $stmt->execute([$msg_id]);
    } elseif ($action === 'mark_unread') {
      $stmt = $conn->prepare("UPDATE contacts SET is_read = 0 WHERE message_id = ?");
      $stmt->execute([$msg_id]);
    } elseif ($action === 'delete') {
      $stmt = $conn->prepare("DELETE FROM contacts WHERE message_id = ?");
      $stmt->execute([$msg_id]);
    }
  }
  header("Location: admin_messages.php");
  exit;
}


$messages = $conn->query("SELECT * FROM contacts ORDER BY submitted_at DESC")->fetchAll(PDO::FETCH_OBJ);

$unread_count = (int) $conn->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
?>

<body>
  <?php include 'includes/admin-sidebar.php'; ?>

  <main class="admin-content">
    <div class="admin-header">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-custom d-lg-none btn-sm-custom" id="sidebarToggle" type="button">
          <i class="bi bi-list" style="font-size:1.2rem;"></i>
        </button>
        <div>
          <h1 class="mb-0">
            إدارة الرسائل
            <?php if ($unread_count > 0): ?>
              <span class="status-badge status-pending ms-2" style="font-size:0.7rem;vertical-align:middle;">
                <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                <span><?= $unread_count ?></span> جديدة
              </span>
            <?php endif; ?>
          </h1>
        </div>
      </div>
    </div>

    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div class="table-responsive">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th>المرسل</th>
              <th>البريد الإلكتروني</th>
              <th>الموضوع</th>
              <th>الرسالة</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($messages) === 0): ?>
              <tr>
                <td colspan="7" class="text-center py-4">لا توجد رسائل.</td>
              </tr>
            <?php endif; ?>

            <?php foreach ($messages as $message): ?>
              <?php
              $name = htmlspecialchars($message->name);
              $email = htmlspecialchars($message->email);
              $subject = htmlspecialchars($message->subject ?: 'بدون موضوع');
              $date = $message->submitted_at;
              $is_unread = (int)$message->is_read === 0;
              $message_text = htmlspecialchars($message->message);
              $message_show = mb_strlen($message_text) > 50 ? mb_substr($message_text, 0, 50) . '...' : $message_text;
              ?>
              <tr class="<?= $is_unread ? 'row-unread' : '' ?>">
                <td data-label="المرسل"><strong><?= $name ?></strong></td>
                <td data-label="البريد الإلكتروني"><?= $email ?></td>
                <td data-label="الموضوع"><strong><?= $subject ?></strong></td>
                <td data-label="الرسالة"><span class="text-muted-custom"><?= nl2br($message_show) ?></span></td>
                <td data-label="التاريخ"><?= $date ?></td>
                <td data-label="الحالة">
                  <?php if ($is_unread): ?>
                    <span class="status-badge status-pending"><i class="bi bi-envelope-fill"></i> جديدة</span>
                  <?php else: ?>
                    <span class="status-badge status-completed"><i class="bi bi-envelope-open"></i> مقروءة</span>
                  <?php endif; ?>
                </td>
                <td data-label="الإجراءات">
                  <div class="d-flex gap-1 justify-content-end">
                    <a class="btn btn-outline-custom btn-sm-custom" href="message_details.php?id=<?= $message->message_id ?>" title="عرض التفاصيل">
                      <i class="bi bi-eye"></i>
                    </a>
                    <?php if ($is_unread): ?>
                      <form method="POST" style="margin:0;">
                        <input type="hidden" name="action" value="mark_read">
                        <input type="hidden" name="message_id" value="<?= $message->message_id ?>">
                        <button class="btn btn-sm-custom btn-make-read" type="submit" title="تحديد كمقروء">
                          <i class="bi bi-check2"></i>
                        </button>
                      </form>
                    <?php else: ?>
                      <form method="POST" style="margin:0;">
                        <input type="hidden" name="action" value="mark_unread">
                        <input type="hidden" name="message_id" value="<?= $message->message_id ?>">
                        <button class="btn btn-sm-custom btn-make-unread" type="submit" title="تحديد كغير مقروء">
                          <i class="bi bi-envelope-fill"></i>
                        </button>
                      </form>
                    <?php endif; ?>
                    <form method="POST" style="margin:0;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="message_id" value="<?= $message->message_id ?>">
                      <button class="btn btn-danger-soft" type="submit" title="حذف" style="border:none;">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL . 'js/main.js'; ?>"></script>
</body>

</html>