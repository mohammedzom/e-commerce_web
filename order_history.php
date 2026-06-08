<?php
$page_title = 'متجرنا — سجل الطلبات';
$page_description = 'سجل الطلبات الخاصة بك.';
require __DIR__ . '/config/config.php';
require __DIR__ . '/includes/middleware/check-login.php';
include __DIR__ . '/includes/header.php';

$user_id = $_SESSION['user_id'];
$status_map = [
  'completed' => [
    'class' => 'status-completed',
    'icon' => 'bi-check-circle-fill',
    'label' => 'مكتمل'
  ],
  'pending' => [
    'class' => 'status-pending',
    'icon' => 'bi-clock-fill',
    'label' => 'قيد الانتظار'
  ],
  'processing' => [
    'class' => 'status-processing',
    'icon' => 'bi-arrow-repeat',
    'label' => 'قيد المعالجة'
  ],
  'shipped' => [
    'class' => 'status-shipped',
    'icon' => 'bi-truck',
    'label' => 'تم الشحن'
  ],
  'cancelled' => [
    'class' => 'status-cancelled',
    'icon' => 'bi-x-circle-fill',
    'label' => 'ملغي'
  ],
  'delivered' => [
    'class' => 'status-completed',
    'icon' => 'bi-check-circle-fill',
    'label' => 'تم التوصيل'
  ],
  'paid' => [
    'class' => 'status-processing',
    'icon' => 'bi-credit-card-fill',
    'label' => 'مدفوع'
  ],
];
$orders = $conn->prepare("
  SELECT o.*, COALESCE(items_summary.total_items, 0) AS total_items
  FROM orders o
  LEFT JOIN (
    SELECT order_id, COUNT(*) AS total_items
    FROM order_items
    GROUP BY order_id
  ) items_summary ON items_summary.order_id = o.order_id
  WHERE o.user_id = :user_id
  ORDER BY o.order_date DESC
");
$orders->execute(['user_id' => $user_id]);
$orders = $orders->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <?php include __DIR__ . '/includes/navbar.php'; ?>
  <div class="page-header">
    <div class="container">
      <h1>سجل الطلبات</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <a href="profile.php">حسابي</a>
        <span class="separator">/</span>
        <span>سجل الطلبات</span>
      </div>
    </div>
  </div>

  <section class="section-padding">
    <div class="container">
      <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>رقم الطلب</th>
                <th>التاريخ</th>
                <th>المنتجات</th>
                <th>الإجمالي</th>
                <th>الحالة</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($orders) === 0): ?>
                <tr>
                  <td colspan="5" class="text-center py-4">لا توجد طلبات سابقة.</td>
                </tr>
              <?php endif; ?>
              <?php foreach ($orders as $order): ?>
                <?php
                $order_status = strtolower((string) $order->status);
                $status = $status_map[$order_status] ?? [
                  'class' => 'status-processing',
                  'icon' => 'bi-info-circle-fill',
                  'label' => $order->status
                ];
                ?>
                <tr>
                  <td><strong>#ORD-<?php echo $order->order_id; ?></strong></td>
                  <td><?php echo date('Y-m-d', strtotime($order->order_date)); ?></td>
                  <td><?php echo (int) $order->total_items; ?> منتجات</td>
                  <td><?php echo number_format((float) $order->total_amount, 2); ?> ش</td>
                  <td>
                    <span class="status-badge <?php echo $status['class']; ?>">
                      <i class="bi <?php echo $status['icon']; ?>"></i>
                      <?php echo htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
