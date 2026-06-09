<?php
$page_description = 'إدارة الرسائل — عرض وإدارة رسائل الزوار والعملاء.';
$page_title = 'إدارة الرسائل';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$messages = $conn->query("
  SELECT
    ` message_id` AS message_id,
    name,
    email,
    subject,
    message,
    is_read,
    submitted_at
  FROM contacts
  ORDER BY is_read ASC, submitted_at DESC, ` message_id` DESC
")->fetchAll(PDO::FETCH_OBJ);

$total_messages = (int) $conn->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unread_count = (int) $conn->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
$latest_message_date = $conn->query("SELECT MAX(submitted_at) FROM contacts")->fetchColumn();
$visible_messages = min($total_messages, 8);
?>

<body>
  <?php include 'includes/admin-sidebar.php'; ?>

  <main
    class="admin-content admin-messages-page"
    id="adminMessagesPage"
    data-endpoint="<?php echo APPURL; ?>actions/admin_messages_action.php"
    data-page-size="8">
    <div class="admin-header">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-custom d-lg-none btn-sm-custom" id="sidebarToggle" type="button">
          <i class="bi bi-list" style="font-size:1.2rem;"></i>
        </button>
        <div>
          <h1 class="mb-0">
            إدارة الرسائل
            <span class="status-badge status-pending ms-2" style="font-size:0.7rem;vertical-align:middle;">
              <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
              <span id="unreadCount"><?php echo $unread_count; ?></span> جديدة
            </span>
          </h1>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-custom btn-sm-custom" id="deleteSelectedBtn" type="button" style="color:var(--color-danger);border-color:var(--color-danger-light);display:none;">
          <i class="bi bi-trash3 me-1"></i>حذف المحدد
        </button>
        <button class="btn btn-outline-custom btn-sm-custom" id="markAllReadBtn" type="button" <?php echo $unread_count === 0 ? 'disabled' : ''; ?>>
          <i class="bi bi-check-all me-1"></i>تحديد الكل كمقروء
        </button>
      </div>
    </div>

    <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
      <div class="row g-3 align-items-end">
        <div class="col-md-5">
          <label class="form-label-custom" for="adminMsgSearch">بحث</label>
          <input type="text" class="form-control form-control-custom" placeholder="الاسم أو البريد أو الموضوع ..." id="adminMsgSearch">
        </div>
        <div class="col-md-3">
          <label class="form-label-custom" for="adminMsgStatus">الحالة</label>
          <select class="form-select form-select-custom" id="adminMsgStatus">
            <option value="">الكل</option>
            <option value="unread">غير مقروءة</option>
            <option value="read">مقروءة</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label-custom" for="adminMsgDate">التاريخ</label>
          <input type="date" class="form-control form-control-custom" id="adminMsgDate">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-custom w-100" id="adminMsgFilterBtn" type="button">
            <i class="bi bi-funnel me-1"></i>تصفية
          </button>
        </div>
      </div>
    </div>

    <div id="bulkBar" style="display:none;background:var(--color-primary-light);border:1px solid rgba(106,173,207,0.3);border-radius:var(--radius-md);padding:0.6rem 1.2rem;margin-bottom:var(--space-md);font-size:var(--font-size-sm);color:var(--color-primary-hover);align-items:center;gap:var(--space-md);">
      <i class="bi bi-check2-square"></i>
      <span><span id="bulkCount">0</span> رسالة محددة</span>
      <button class="btn btn-sm btn-outline-custom btn-sm-custom ms-auto" id="bulkMarkRead" type="button">
        <i class="bi bi-envelope-open me-1"></i>تحديد كمقروء
      </button>
    </div>

    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div class="table-responsive">
        <table class="table table-custom mb-0" id="adminMessagesTable">
          <thead>
            <tr>
              <th style="width:5%;">
                <input class="form-check-input" type="checkbox" id="selectAllMsgs" style="cursor:pointer;width:16px;height:16px;" <?php echo $total_messages === 0 ? 'disabled' : ''; ?>>
              </th>
              <th>المرسل</th>
              <th>البريد الإلكتروني</th>
              <th>الموضوع</th>
              <th>مقتطف</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($messages) === 0): ?>
              <tr>
                <td colspan="8" class="text-center py-4">لا توجد رسائل.</td>
              </tr>
            <?php endif; ?>

            <?php foreach ($messages as $message): ?>
              <?php
              $name = $message->name;
              $email = $message->email;
              $subject = $message->subject ?: 'بدون موضوع';
              $body = $message->message;
              $is_unread = (int)$message->is_read === 0;
              $date_value = $message->submitted_at ? date('Y-m-d', strtotime($message->submitted_at)) : '';
              $date_text = $message->submitted_at ? date('Y-m-d H:i', strtotime($message->submitted_at)) : '-';
              $preview = mb_strlen($body, 'UTF-8') > 30 ? mb_substr($body, 0, 30, 'UTF-8') . '...' : $body;
              $status_class = $is_unread ? 'status-pending' : 'status-completed';
              $status_icon = $is_unread ? 'bi-envelope-fill' : 'bi-envelope-open';
              $status_text = $is_unread ? 'جديدة' : 'مقروءة';
              ?>
              <tr class="<?= $is_unread ? 'row-unread ' : '' ?>msg-row"
                data-id="<?= $message->message_id ?>"
                data-status="<?= $is_unread ? 'unread' : 'read' ?>"
                data-name="<?= htmlspecialchars($name) ?>"
                data-email="<?= htmlspecialchars($email) ?>"
                data-subject="<?= htmlspecialchars($subject) ?>"
                data-body="<?= htmlspecialchars($body) ?>"
                data-date="<?= htmlspecialchars($date_text) ?>"
                data-date-value="<?= htmlspecialchars($date_value) ?>">
                <td data-label="تحديد">
                  <input class="form-check-input row-check" type="checkbox" style="cursor:pointer;">
                </td>
                <td data-label="المرسل">
                  <strong><?= htmlspecialchars($name) ?></strong>
                </td>
                <td data-label="البريد الإلكتروني"><?= htmlspecialchars($email) ?></td>
                <td data-label="الموضوع">
                  <strong class="<?= $is_unread ? 'text-primary-custom' : '' ?>"><?= htmlspecialchars($subject) ?></strong>
                </td>
                <td data-label="مقتطف"><span class="text-muted-custom"><?= htmlspecialchars($preview) ?></span></td>
                <td data-label="التاريخ"><?= htmlspecialchars($date_text) ?></td>
                <td data-label="الحالة">
                  <span class="status-badge <?= $status_class ?>">
                    <i class="bi <?= $status_icon ?>"></i> <?= $status_text ?>
                  </span>
                </td>
                <td data-label="الإجراءات">
                  <div class="d-flex gap-1 justify-content-end">
                    <button class="btn btn-outline-custom btn-sm-custom btn-view-msg" type="button" title="عرض التفاصيل">
                      <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm-custom btn-toggle-read <?= $is_unread ? 'btn-make-unread' : 'btn-make-read' ?>" type="button" title="<?= $is_unread ? 'تحديد كمقروء' : 'تحديد كغير مقروء' ?>">
                      <i class="bi <?= $is_unread ? 'bi-check2' : 'bi-envelope' ?>"></i>
                    </button>
                    <button class="btn btn-danger-soft btn-delete-msg" type="button" title="حذف">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div id="emptyState" style="display:none;text-align:center;padding:3rem 1rem;">
      <i class="bi bi-inbox" style="font-size:2.5rem;color:var(--color-text-muted);display:block;margin-bottom:1rem;"></i>
      <p style="color:var(--color-text-muted);font-size:var(--font-size-sm);margin:0;">لا توجد رسائل تطابق البحث</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
      <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);" id="paginationInfo">
        عرض <?php echo $total_messages > 0 ? '1' : '0'; ?> إلى <?php echo $visible_messages; ?> من <?php echo $total_messages; ?> رسالة
      </p>
      <nav>
        <ul class="pagination mb-0" id="messagesPagination" style="gap:4px;"></ul>
      </nav>
    </div>
  </main>
  </div>

  <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
      <div class="modal-content" style="border:none;border-radius:var(--radius-xl);box-shadow:var(--shadow-xl);">
        <div class="modal-header" style="border-bottom:1px solid var(--color-border-light);padding:1.25rem 1.5rem;">
          <div class="d-flex align-items-center gap-2">
            <div style="width:34px;height:34px;border-radius:var(--radius-full);background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);">
              <i class="bi bi-envelope-open" style="font-size:0.9rem;"></i>
            </div>
            <h5 class="modal-title mb-0" id="messageModalLabel" style="font-weight:700;font-size:var(--font-size-base);">تفاصيل الرسالة</h5>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>

        <div class="modal-body" style="padding:1.5rem;">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div id="modalAvatar" style="width:46px;height:46px;border-radius:50%;background:var(--color-primary-light);color:var(--color-primary);display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;flex-shrink:0;"></div>
            <div style="flex:1;min-width:0;">
              <p id="modalName" style="font-weight:700;margin:0;font-size:var(--font-size-base);"></p>
              <p id="modalEmail" style="font-size:var(--font-size-xs);color:var(--color-text-muted);margin:0;"></p>
            </div>
            <span id="modalDate" style="font-size:var(--font-size-xs);color:var(--color-text-muted);white-space:nowrap;"></span>
          </div>

          <hr style="border-color:var(--color-border-light);margin:0 0 1.25rem;">
          <p id="modalSubject" style="font-weight:700;font-size:var(--font-size-sm);margin-bottom:0.75rem;color:var(--color-text);"></p>
          <p id="modalBody" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);line-height:2;margin:0;background:var(--color-bg);border-radius:var(--radius-md);padding:1rem 1.25rem;border:1px solid var(--color-border-light);"></p>
        </div>

        <div class="modal-footer" style="border-top:1px solid var(--color-border-light);padding:1rem 1.5rem;gap:0.5rem;">
          <button type="button" class="btn btn-danger-soft" id="modalDeleteBtn">
            <i class="bi bi-trash3 me-1"></i>حذف
          </button>
          <div style="flex:1;"></div>
          <button type="button" class="btn btn-outline-custom btn-sm-custom" data-bs-dismiss="modal">إغلاق</button>
          <a id="modalReplyBtn" href="#" class="btn btn-primary-custom btn-sm-custom">
            <i class="bi bi-reply me-1"></i>رد عبر البريد
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL . 'js/main.js'; ?>"></script>
  <script src="<?php echo APPURL . 'js/admin_messages.js'; ?>"></script>
</body>

</html>