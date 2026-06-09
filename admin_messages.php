<?php
$page_description = "إدارة الرسائل — عرض وإدارة رسائل الزوار والعملاء.";
$page_title = "متجرنا — إدارة الرسائل";
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$messages = $conn->prepare("SELECT * FROM contacts ORDER BY is_read ASC");
$messages->execute();
$messages = $messages->fetchAll(PDO::FETCH_OBJ);

$unreadCount = $conn->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
$totalMessages = count($messages);
?>

<body>

  <?php include 'includes/admin-sidebar.php'; ?>
  <main class="admin-content admin-messages-page">
    <div class="admin-header">
      <div class="admin-message-heading">
        <button class="btn btn-outline-custom admin-sidebar-toggle d-lg-none" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <h1>
          إدارة الرسائل
          <span class="status-badge status-unread messages-count-badge"><?= $unreadCount ?> جديدة</span>
        </h1>
      </div>
      <form action="actions/mark-all-read.php" method="POST" class="m-0">
        <button class="btn btn-outline-custom btn-sm-custom" type="submit" name="mark-all-read" id="markAllReadBtn">
          <i class="bi bi-check-all me-1"></i>تحديد الكل كمقروء
        </button>
      </form>
    </div>

    <div class="card-custom messages-toolbar">
      <div class="row g-3 align-items-end">
        <div class="col-md-5">
          <label class="form-label-custom">بحث</label>
          <input type="text" class="form-control form-control-custom" placeholder="الاسم أو البريد أو الموضوع ..." id="adminMsgSearch">
        </div>
        <div class="col-md-3">
          <label class="form-label-custom">الحالة</label>
          <select class="form-select form-select-custom" id="adminMsgStatus">
            <option>الكل</option>
            <option>غير مقروءة</option>
            <option>مقروءة</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label-custom">التاريخ</label>
          <input type="date" class="form-control form-control-custom" id="adminMsgDate">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-custom w-100" id="adminMsgFilterBtn">
            <i class="bi bi-funnel me-1"></i>تصفية
          </button>
        </div>
      </div>
    </div>

    <div class="card-custom messages-table-card">
      <div class="table-responsive">
        <table class="table table-custom messages-table mb-0" id="adminMessagesTable">
          <thead>
            <tr>
              <th class="message-select-cell">
                <input class="form-check-input" type="checkbox" id="selectAllMsgs">
              </th>
              <th>المرسل</th>
              <th>البريد الإلكتروني</th>
              <th>الموضوع</th>
              <th>مقتطف الرسالة</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($totalMessages === 0) : ?>
              <tr>
                <td colspan="8" class="messages-empty">
                  <div class="messages-empty-icon"><i class="bi bi-inbox"></i></div>
                  <strong>لا توجد رسائل حالياً</strong>
                  <span>ستظهر رسائل العملاء والزوار هنا فور وصولها.</span>
                </td>
              </tr>
            <?php endif; ?>
            <?php foreach ($messages as $message) : ?>
              <?php
              $messageId = $message->id ?? '';
              $messageName = (string) ($message->name ?? '');
              $messageEmail = (string) ($message->email ?? '');
              $messageSubject = trim((string) ($message->subject ?? ''));
              $messageSubject = $messageSubject !== '' ? $messageSubject : 'بدون موضوع';
              $messageBody = (string) ($message->message ?? '');
              $messageInitial = function_exists('mb_substr') ? mb_substr($messageName, 0, 1, 'UTF-8') : substr($messageName, 0, 1);
              $messageInitial = $messageInitial !== '' ? $messageInitial : '؟';
              $messageTimestamp = !empty($message->submitted_at) ? strtotime($message->submitted_at) : false;
              $messageDate = $messageTimestamp ? date('Y-m-d - h:i A', $messageTimestamp) : 'غير محدد';
              $messageDateValue = $messageTimestamp ? date('Y-m-d', $messageTimestamp) : '';
              $isRead = (bool) ($message->is_read ?? false);
              $messageStatus = $isRead ? 'مقروءة' : 'غير مقروءة';
              $rowSearch = strtolower($messageName . ' ' . $messageEmail . ' ' . $messageSubject . ' ' . $messageBody);
              ?>
              <tr class="message-row <?= $isRead ? 'message-row-read' : 'message-row-unread'; ?>"
                data-message-status="<?= $isRead ? 'read' : 'unread'; ?>"
                data-message-date="<?= htmlspecialchars($messageDateValue, ENT_QUOTES, 'UTF-8'); ?>"
                data-message-search="<?= htmlspecialchars($rowSearch, ENT_QUOTES, 'UTF-8'); ?>">
                <td class="message-select-cell"><input class="form-check-input message-checkbox" type="checkbox"></td>
                <td>
                  <div class="message-sender">
                    <div class="profile-avatar message-avatar <?= $isRead ? '' : 'message-avatar-unread'; ?>"><?= htmlspecialchars($messageInitial, ENT_QUOTES, 'UTF-8') ?></div>
                    <strong class="message-sender-name"><?= htmlspecialchars($messageName, ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>
                </td>
                <td><a class="message-email" href="mailto:<?= htmlspecialchars($messageEmail, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($messageEmail, ENT_QUOTES, 'UTF-8') ?></a></td>
                <td><strong class="message-subject"><?= htmlspecialchars($messageSubject, ENT_QUOTES, 'UTF-8') ?></strong></td>
                <td><span class="message-preview"><?= htmlspecialchars($messageBody, ENT_QUOTES, 'UTF-8') ?></span></td>
                <td><span class="message-date"><?= htmlspecialchars($messageDate, ENT_QUOTES, 'UTF-8') ?></span></td>
                <td><span class="status-badge <?= $isRead ? "status-read" : "status-unread"; ?>"><i class="bi <?= $isRead ? 'bi-envelope-open-fill' : 'bi-envelope-fill'; ?>"></i> <?= $messageStatus ?></span></td>
                <td>
                  <div class="message-actions">
                    <button class="btn btn-outline-custom message-action-btn"
                      type="button"
                      title="عرض الرسالة"
                      data-bs-toggle="modal"
                      data-bs-target="#messageModal"
                      data-message-name="<?= htmlspecialchars($messageName, ENT_QUOTES, 'UTF-8') ?>"
                      data-message-email="<?= htmlspecialchars($messageEmail, ENT_QUOTES, 'UTF-8') ?>"
                      data-message-subject="<?= htmlspecialchars($messageSubject, ENT_QUOTES, 'UTF-8') ?>"
                      data-message-body="<?= htmlspecialchars($messageBody, ENT_QUOTES, 'UTF-8') ?>"
                      data-message-date="<?= htmlspecialchars($messageDate, ENT_QUOTES, 'UTF-8') ?>"
                      data-message-initial="<?= htmlspecialchars($messageInitial, ENT_QUOTES, 'UTF-8') ?>">
                      <i class="bi bi-eye"></i>
                    </button>
                    <?php if (!$isRead) : ?>
                      <form action="actions/message_handler.php?make=read" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $messageId, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="btn btn-success-soft message-action-btn" title="تحديد كمقروء"><i class="bi bi-check2"></i></button>
                      </form>
                    <?php else : ?>
                      <form action="actions/message_handler.php?make=unread" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $messageId, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="btn btn-make-read message-action-btn" title="تحديد كغير مقروء"><i class="bi bi-envelope"></i></button>
                      </form>
                    <?php endif; ?>
                    <form action="actions/delete-message.php" method="POST">
                      <input type="hidden" name="id" value="<?= htmlspecialchars((string) $messageId, ENT_QUOTES, 'UTF-8') ?>">
                      <button class="btn btn-danger-soft message-action-btn" title="حذف"><i class="bi bi-trash3"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr class="messages-no-results d-none">
              <td colspan="8" class="messages-empty">
                <div class="messages-empty-icon"><i class="bi bi-search"></i></div>
                <strong>لا توجد نتائج مطابقة</strong>
                <span>جرّب تعديل البحث أو فلتر الحالة والتاريخ.</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="messages-footer">
      <p class="text-muted-custom mb-0">عرض <?= $totalMessages ?> رسالة</p>
      <div class="messages-footer-meta">
        <span><i class="bi bi-envelope-fill"></i><?= $unreadCount ?> غير مقروءة</span>
        <span><i class="bi bi-envelope-open-fill"></i><?= max($totalMessages - (int) $unreadCount, 0) ?> مقروءة</span>
      </div>
    </div>
  </main>
  </div>

  <!-- MESSAGE DETAIL MODAL -->
  <div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content message-modal">
        <div class="modal-header message-modal-header">
          <h5 class="modal-title">
            <i class="bi bi-envelope-open ms-2 text-primary-custom"></i>تفاصيل الرسالة
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body message-modal-body-wrap">
          <div class="message-modal-meta">
            <div class="message-modal-sender">
              <div class="profile-avatar message-modal-avatar" id="messageModalAvatar">؟</div>
              <div>
                <h6 id="messageModalName">اسم المرسل</h6>
                <a href="#" id="messageModalEmail">email@example.com</a>
              </div>
            </div>
            <span id="messageModalDate" class="message-modal-date">غير محدد</span>
          </div>
          <div class="message-modal-content">
            <h6 class="message-modal-subject">
              الموضوع:
              <span id="messageModalSubject">بدون موضوع</span>
            </h6>
            <p id="messageModalBody" class="message-modal-body">
              اختر رسالة من الجدول لعرض تفاصيلها.
            </p>
          </div>
        </div>
        <div class="modal-footer message-modal-footer">
          <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">إغلاق</button>
          <a class="btn btn-primary-custom" href="#" id="messageModalReply">
            <i class="bi bi-reply me-1"></i>رد عبر البريد
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var messageModal = document.getElementById('messageModal');
      var searchInput = document.getElementById('adminMsgSearch');
      var statusSelect = document.getElementById('adminMsgStatus');
      var dateInput = document.getElementById('adminMsgDate');
      var filterBtn = document.getElementById('adminMsgFilterBtn');
      var selectAll = document.getElementById('selectAllMsgs');
      var messageRows = Array.prototype.slice.call(document.querySelectorAll('.message-row'));
      var noResultsRow = document.querySelector('.messages-no-results');

      if (messageModal) {
        messageModal.addEventListener('show.bs.modal', function(event) {
          var button = event.relatedTarget;
          if (!button) return;

          var name = button.getAttribute('data-message-name') || 'اسم المرسل';
          var email = button.getAttribute('data-message-email') || '';
          var subject = button.getAttribute('data-message-subject') || 'بدون موضوع';
          var body = button.getAttribute('data-message-body') || '';
          var date = button.getAttribute('data-message-date') || 'غير محدد';
          var initial = button.getAttribute('data-message-initial') || '؟';

          messageModal.querySelector('#messageModalAvatar').textContent = initial;
          messageModal.querySelector('#messageModalName').textContent = name;
          messageModal.querySelector('#messageModalEmail').textContent = email || 'بدون بريد';
          messageModal.querySelector('#messageModalEmail').href = email ? 'mailto:' + email : '#';
          messageModal.querySelector('#messageModalDate').textContent = date;
          messageModal.querySelector('#messageModalSubject').textContent = subject;
          messageModal.querySelector('#messageModalBody').textContent = body;
          messageModal.querySelector('#messageModalReply').href = email ? 'mailto:' + email + '?subject=' + encodeURIComponent('RE: ' + subject) : '#';
        });
      }

      function applyMessageFilters() {
        var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        var statusValue = statusSelect ? statusSelect.value : 'الكل';
        var dateValue = dateInput ? dateInput.value : '';
        var visibleCount = 0;

        messageRows.forEach(function(row) {
          var matchesSearch = !query || row.getAttribute('data-message-search').indexOf(query) !== -1;
          var matchesStatus = statusValue === 'الكل' ||
            (statusValue === 'غير مقروءة' && row.getAttribute('data-message-status') === 'unread') ||
            (statusValue === 'مقروءة' && row.getAttribute('data-message-status') === 'read');
          var matchesDate = !dateValue || row.getAttribute('data-message-date') === dateValue;
          var isVisible = matchesSearch && matchesStatus && matchesDate;

          row.classList.toggle('d-none', !isVisible);
          if (isVisible) visibleCount++;
        });

        if (noResultsRow) {
          noResultsRow.classList.toggle('d-none', visibleCount !== 0 || messageRows.length === 0);
        }
      }

      if (filterBtn) {
        filterBtn.addEventListener('click', function(event) {
          event.preventDefault();
          applyMessageFilters();
        });
      }

      [searchInput, statusSelect, dateInput].forEach(function(control) {
        if (control) {
          control.addEventListener('input', applyMessageFilters);
          control.addEventListener('change', applyMessageFilters);
        }
      });

      if (selectAll) {
        selectAll.addEventListener('change', function() {
          document.querySelectorAll('.message-checkbox').forEach(function(checkbox) {
            var row = checkbox.closest('.message-row');
            checkbox.checked = selectAll.checked && row && !row.classList.contains('d-none');
          });
        });
      }
    });
  </script>
</body>

</html>
