<?php
$page_description = "لوحة التحكم — إدارة المتجر ومتابعة الإحصائيات.";
$page_title = "متجرنا — لوحة التحكم";
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

$totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$totalMessages = $conn->query("SELECT COUNT(*) FROM contacts WHERE is_read = false")->fetchColumn();



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
  SELECT 
    o.*, 
    u.full_name,
    COALESCE(items_summary.total_items, 0) AS total_items
  FROM orders o
  JOIN users u ON o.user_id = u.user_id 
  LEFT JOIN (
    SELECT order_id, COUNT(*) AS total_items
    FROM order_items
    GROUP BY order_id
  ) items_summary ON items_summary.order_id = o.order_id
  ORDER BY o.order_date DESC
  LIMIT 5
");

$orders->execute();
$orders = $orders->fetchAll(PDO::FETCH_OBJ);


$stmt = $conn->prepare("
    SELECT 
      p.product_id,
      p.name,
      p.price,
      p.image_url,
      SUM(oi.quantity) AS total_sold
    FROM order_items oi
    JOIN products p ON p.product_id = oi.product_id
    JOIN orders   o ON o.order_id   = oi.order_id
    WHERE o.status != 'cancelled'
    GROUP BY p.product_id
    ORDER BY total_sold DESC
    LIMIT 5
");
$stmt->execute();
$topProducts = $stmt->fetchAll(PDO::FETCH_OBJ);



?>


<?php include 'includes/admin-sidebar.php'; ?>

<!-- MAIN CONTENT -->
<main class="admin-content">
  <!-- Top Bar -->
  <div class="admin-header">
    <div>
      <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
        <i class="bi bi-list" style="font-size:1.25rem;"></i>
      </button>
      <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">لوحة التحكم</h1>
    </div>

    <div class="d-flex align-items-center gap-2">
      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-sm);"><?php echo $_SESSION['full_name'][0]; ?></div>
      <span style="font-size:var(--font-size-sm);font-weight:600;">المدير</span>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon bg-primary-light text-primary-custom">
          <i class="bi bi-box-seam"></i>
        </div>
        <div class="stat-value"><?php echo $totalProducts; ?></div>
        <div class="stat-label">إجمالي المنتجات</div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon bg-success-light text-success-custom">
          <i class="bi bi-receipt"></i>
        </div>
        <div class="stat-value"><?php echo $totalOrders; ?></div>
        <div class="stat-label">إجمالي الطلبات</div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon bg-info-light" style="color:var(--color-info);">
          <i class="bi bi-people"></i>
        </div>
        <div class="stat-value"><?php echo $totalUsers; ?></div>
        <div class="stat-label">إجمالي المستخدمين</div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-icon bg-warning-light text-warning-custom">
          <i class="bi bi-chat-dots"></i>
        </div>
        <div class="stat-value"><?php echo $totalMessages; ?></div>
        <div class="stat-label">رسائل جديدة</div>
      </div>
    </div>
  </div>

  <!-- Recent Orders & Quick Stats -->
  <div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
      <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 style="font-weight:700;margin-bottom:0;">
            <i class="bi bi-receipt ms-2 text-primary-custom"></i>
            أحدث الطلبات
          </h5>
          <a href="admin_orders.php" class="btn btn-outline-custom btn-sm-custom">عرض الكل</a>
        </div>
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>رقم الطلب</th>
                <th>العميل</th>
                <th>الإجمالي</th>
                <th>الحالة</th>
                <th>التاريخ</th>
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
                  <td><?php echo $order->full_name; ?></td>
                  <td><?php echo number_format((float) $order->total_amount, 2); ?> ش</td>
                  <td><span class="status-badge <?php echo $status['class']; ?>"><i class="bi <?php echo $status['icon']; ?>"></i> <?php echo htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                  <td><?php echo date('Y-m-d', strtotime($order->order_date)); ?></td>
                </tr>
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Quick Stats / Top Products -->
    <div class="col-lg-4">
      <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
        <h5 style="font-weight:700;margin-bottom:var(--space-lg);">
          <i class="bi bi-star ms-2 text-primary-custom"></i>
          المنتجات الأكثر مبيعاً
        </h5>
        <div class="d-flex flex-column gap-3">
          <!-- Top Product 1 -->
          <?php foreach ($topProducts as $product): ?>
            <div class="d-flex align-items-center gap-3">
              <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                <img src="<?php echo $product->image_url; ?>" alt="<?php echo $product->name; ?>" style="width:100%;height:100%;object-fit:cover;">
              </div>
              <div style="flex:1;min-width:0;">
                <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo $product->name; ?></h6>
                <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);"><?php echo $product->total_sold; ?> مباع</span>
              </div>
              <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);"><?php echo $product->price; ?> ش</span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>

</html>