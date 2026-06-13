<?php
$page_title = 'متجرنا — تفاصيل الرسالة';
$page_description = 'عرض تفاصيل رسالة العميل والرد عليها.';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$message_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($message_id <= 0) {
    header("Location: admin_messages.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'mark_read') {
        $stmt = $conn->prepare("UPDATE contacts SET is_read = 1 WHERE message_id = ?");
        $stmt->execute([$message_id]);
        header("Location: message_details.php?id=" . $message_id);
        exit;
    } elseif ($action === 'mark_unread') {
        $stmt = $conn->prepare("UPDATE contacts SET is_read = 0 WHERE message_id = ?");
        $stmt->execute([$message_id]);
        header("Location: message_details.php?id=" . $message_id);
        exit;
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM contacts WHERE message_id = ?");
        $stmt->execute([$message_id]);
        header("Location: admin_messages.php");
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM contacts WHERE message_id = :id");
$stmt->execute(['id' => $message_id]);
$message = $stmt->fetch(PDO::FETCH_OBJ);

if (!$message) {
    header("Location: admin_messages.php");
    exit;
}

if (!$message->is_read) {
    $markRead = $conn->prepare("UPDATE contacts SET is_read = 1 WHERE message_id = ?");
    $markRead->execute([$message_id]);
    $message->is_read = 1;
}

$is_read = boolval($message->is_read);
$name = htmlspecialchars($message->name);
$email = htmlspecialchars($message->email);
$subject = htmlspecialchars($message->subject ?: 'بدون موضوع');
$message_text = htmlspecialchars($message->message);
$date = date('Y-m-d', strtotime($message->submitted_at));
$time = date('H:i', strtotime($message->submitted_at));
?>

<body>
    <?php include 'includes/admin-sidebar.php'; ?>

    <main class="admin-content">
        <div class="admin-header">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
                    <i class="bi bi-list" style="font-size:1.25rem;"></i>
                </button>
                <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">
                    تفاصيل الرسالة
                </h1>
            </div>
            <a href="admin_messages.php" class="btn btn-outline-custom btn-sm-custom">
                <i class="bi bi-arrow-right me-1"></i>العودة للرسائل
            </a>
        </div>
    <?= displayFlash() ?>


        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-custom msg-sender-card">
                    <div class="msg-sender-header">
                        <div class="msg-sender-avatar">
                            <?= mb_substr($name, 0, 1, 'UTF-8') ?>
                        </div>
                        <h5><?= $name ?></h5>
                        <p>
                            <?= $is_read
                                ? '<span class="status-badge status-completed"><i class="bi bi-envelope-open"></i> مقروءة</span>'
                                : '<span class="status-badge status-pending"><i class="bi bi-envelope-fill"></i> جديدة</span>'
                            ?>
                        </p>
                    </div>

                    <div class="msg-info-list">
                        <div class="d-flex align-items-center gap-3 mb-3 msg-info-item">
                            <div class="msg-info-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div style="min-width:0;">
                                <small class="msg-info-label">البريد الإلكتروني</small>
                                <a href="mailto:<?= $email ?>" class="msg-info-value msg-info-value--email"><?= $email ?></a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-3 msg-info-item">
                            <div class="msg-info-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div>
                                <small class="msg-info-label">تاريخ الإرسال</small>
                                <span class="msg-info-value"><?= $date ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 msg-info-item">
                            <div class="msg-info-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <small class="msg-info-label">وقت الإرسال</small>
                                <span class="msg-info-value"><?= $time ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="msg-actions">
                        <a href="mailto:<?= $email ?>?subject=رد: <?= urlencode($message->subject ?: '') ?>" class="btn btn-primary-custom w-100">
                            <i class="bi bi-reply me-1"></i> الرد عبر البريد
                        </a>

                        <form method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟');">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger-soft w-100">
                                <i class="bi bi-trash3 me-1"></i> حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-custom msg-content-card">
                    <div class="msg-subject-header">
                        <div class="msg-subject-icon">
                            <i class="bi bi-chat-square-text"></i>
                        </div>
                        <div>
                            <small class="msg-info-label">الموضوع</small>
                            <h4><?= $subject ?></h4>
                        </div>
                    </div>

                    <div class="msg-body-wrapper">
                        <div class="msg-body-content">
                            <?= nl2br($message_text) ?>
                        </div>
                    </div>

                    <div class="msg-footer">
                        <div class="msg-footer-meta">
                            <i class="bi bi-info-circle"></i>
                            <span>رقم الرسالة: #MSG-<?= $message_id ?></span>
                        </div>
                        <div class="msg-footer-meta">
                            <i class="bi bi-clock-history"></i>
                            <span>تم الاستلام: <?= $date ?> الساعة <?= $time ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo APPURL . 'js/main.js'; ?>"></script>
</body>

</html>