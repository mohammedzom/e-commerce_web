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
$latest_message_text = $latest_message_date ? date('Y-m-d H:i', strtotime($latest_message_date)) : 'لا توجد رسائل';
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
          <p class="mb-0" style="font-size:var(--font-size-xs);color:var(--color-text-muted);margin-top:2px;">
            إجمالي <span id="totalMessagesCount"><?php echo $total_messages; ?></span> رسالة · آخر رسالة: <?php echo htmlspecialchars($latest_message_text, ENT_QUOTES, 'UTF-8'); ?>
          </p>
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
              $name = (string) $message->name;
              $email = (string) $message->email;
              $subject = $message->subject ? (string) $message->subject : 'بدون موضوع';
              $body = (string) $message->message;
              $status = (int) $message->is_read === 0 ? 'unread' : 'read';
              $is_unread = $status === 'unread';
              $date_value = $message->submitted_at ? date('Y-m-d', strtotime($message->submitted_at)) : '';
              $date_text = $message->submitted_at ? date('Y-m-d H:i', strtotime($message->submitted_at)) : '-';
              $first_letter = function_exists('mb_substr') ? mb_substr(trim($name), 0, 1, 'UTF-8') : substr(trim($name), 0, 1);
              $preview = trim(preg_replace('/\s+/u', ' ', $body));

              if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                $preview = mb_strlen($preview, 'UTF-8') > 45 ? mb_substr($preview, 0, 45, 'UTF-8') . '...' : $preview;
              } else {
                $preview = strlen($preview) > 45 ? substr($preview, 0, 45) . '...' : $preview;
              }

              $status_class = $is_unread ? 'status-pending' : 'status-completed';
              $status_icon = $is_unread ? 'bi-envelope-fill' : 'bi-envelope-open';
              $status_text = $is_unread ? 'جديدة' : 'مقروءة';
              ?>
              <tr class="<?php echo $is_unread ? 'row-unread ' : ''; ?>msg-row"
                data-id="<?php echo (int) $message->message_id; ?>"
                data-status="<?php echo $status; ?>"
                data-name="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"
                data-email="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"
                data-subject="<?php echo htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'); ?>"
                data-body="<?php echo htmlspecialchars($body, ENT_QUOTES, 'UTF-8'); ?>"
                data-date="<?php echo htmlspecialchars($date_text, ENT_QUOTES, 'UTF-8'); ?>"
                data-date-value="<?php echo htmlspecialchars($date_value, ENT_QUOTES, 'UTF-8'); ?>">
                <td>
                  <input class="form-check-input row-check" type="checkbox" style="cursor:pointer;width:16px;height:16px;">
                </td>
                <td>
                  <div class="sender-cell">
                    <div class="avatar-wrap">
                      <div class="msg-avatar <?php echo $is_unread ? '' : 'read'; ?>">
                        <?php echo htmlspecialchars($first_letter ?: '؟', ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                      <?php if ($is_unread): ?>
                        <span class="unread-dot"></span>
                      <?php endif; ?>
                    </div>
                    <span class="sender-name <?php echo $is_unread ? '' : 'read'; ?>">
                      <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                  </div>
                </td>
                <td><span class="msg-email"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td><span class="<?php echo $is_unread ? 'subj-unread' : 'subj-read'; ?>"><?php echo htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td><span class="msg-preview"><?php echo htmlspecialchars($preview, ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td><span class="msg-date"><?php echo htmlspecialchars($date_text, ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td>
                  <span class="status-badge <?php echo $status_class; ?>">
                    <i class="bi <?php echo $status_icon; ?>"></i> <?php echo $status_text; ?>
                  </span>
                </td>
                <td>
                  <div class="msg-actions">
                    <?php if ($is_unread): ?>
                      <button class="btn btn-success-soft btn-mark-read" type="button" title="تحديد كمقروء">
                        <i class="bi bi-check2"></i>
                      </button>
                    <?php endif; ?>
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
