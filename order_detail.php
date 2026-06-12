<?php
$page_title = 'متجرنا — تفاصيل الطلب';
$page_description = 'عرض تفاصيل الطلب ومنتجاته.';
require_once 'config/config.php';
/** @var array<string, array{class: string, icon: string, label: string}> $status_map */
$status_map = $GLOBALS['status_map'];
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$order_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($order_id <= 0) {
  header("Location: admin_orders.php");
  exit;
}

$order_stmt = $conn->prepare("
  SELECT o.*, u.full_name, u.email, u.phone, u.address
  FROM orders o
  JOIN users u ON o.user_id = u.user_id
  WHERE o.order_id = :order_id
");
$order_stmt->execute(['order_id' => $order_id]);
$order = $order_stmt->fetch(PDO::FETCH_OBJ);

if (!$order) {
  header("Location: admin_orders.php");
  exit;
}

$items_stmt = $conn->prepare("
  SELECT oi.*, p.name AS product_name, p.image_url
  FROM order_items oi
  JOIN products p ON p.product_id = oi.product_id
  WHERE oi.order_id = :order_id
");
$items_stmt->execute(['order_id' => $order_id]);
$items = $items_stmt->fetchAll(PDO::FETCH_OBJ);

$order_status = $status_map[$order->status] ?? [
  'class' => 'status-pending',
  'icon' => 'bi-question-circle-fill',
  'label' => $order->status
];
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
          تفاصيل الطلب #ORD-<?= htmlspecialchars($order->order_id) ?>
        </h1>
      </div>
      <a href="admin_orders.php" class="btn btn-outline-custom btn-sm-custom">
        <i class="bi bi-arrow-right me-1"></i>العودة للطلبات
      </a>
    </div>

    <!-- Order Info -->
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
          <h5 style="font-weight:700;margin-bottom:var(--space-md);">معلومات الطلب</h5>
          <table class="table table-custom mb-0" style="font-size:var(--font-size-sm);">
            <tr><td style="font-weight:600;width:40%;">رقم الطلب</td><td>#ORD-<?= htmlspecialchars($order->order_id) ?></td></tr>
            <tr><td style="font-weight:600;">التاريخ</td><td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($order->order_date))) ?></td></tr>
            <tr><td style="font-weight:600;">الإجمالي</td><td><strong><?= htmlspecialchars(number_format((float)$order->total_amount, 2)) ?> ش</strong></td></tr>
            <tr><td style="font-weight:600;">الحالة</td><td><span class="status-badge <?= htmlspecialchars($order_status['class']) ?>"><i class="bi <?= htmlspecialchars($order_status['icon']) ?>"></i> <?= htmlspecialchars($order_status['label']) ?></span></td></tr>
            <tr><td style="font-weight:600;">عنوان الشحن</td><td><?= htmlspecialchars($order->shipping_address ?: '-') ?></td></tr>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
          <h5 style="font-weight:700;margin-bottom:var(--space-md);">معلومات العميل</h5>
          <table class="table table-custom mb-0" style="font-size:var(--font-size-sm);">
            <tr><td style="font-weight:600;width:40%;">الاسم</td><td><?= htmlspecialchars($order->full_name) ?></td></tr>
            <tr><td style="font-weight:600;">البريد الإلكتروني</td><td><?= htmlspecialchars($order->email) ?></td></tr>
            <tr><td style="font-weight:600;">الهاتف</td><td><?= htmlspecialchars($order->phone ?: '-') ?></td></tr>
            <tr><td style="font-weight:600;">العنوان</td><td><?= htmlspecialchars($order->address ?: '-') ?></td></tr>
          </table>
        </div>
      </div>
    </div>

    <!-- Order Items -->
    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div style="padding:var(--space-lg) var(--space-xl) 0;">
        <h5 style="font-weight:700;margin-bottom:0;">منتجات الطلب</h5>
      </div>
      <div class="table-responsive" style="padding:var(--space-md) var(--space-xl) var(--space-xl);">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th>المنتج</th>
              <th>الكمية</th>
              <th>سعر الوحدة</th>
              <th>المجموع</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($items) === 0): ?>
              <tr><td colspan="4" class="text-center py-4">لا توجد منتجات.</td></tr>
            <?php endif; ?>
            <?php foreach ($items as $item): ?>
              <tr>
                <td data-label="المنتج"><strong><?= htmlspecialchars($item->product_name) ?></strong></td>
                <td data-label="الكمية"><?= htmlspecialchars($item->quantity) ?></td>
                <td data-label="سعر الوحدة"><?= htmlspecialchars(number_format((float)$item->unit_price, 2)) ?> ش</td>
                <td data-label="المجموع"><strong><?= htmlspecialchars(number_format((float)$item->unit_price * (int)$item->quantity, 2)) ?> ش</strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" style="font-weight:700;text-align:left;">الإجمالي</td>
              <td style="font-weight:700;"><?= htmlspecialchars(number_format((float)$order->total_amount, 2)) ?> ش</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
