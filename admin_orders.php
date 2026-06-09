<?php
$page_description = "إدارة الطلبات — متابعة وتحديث حالة الطلبات في المتجر.";
$page_title = "متجرنا — إدارة الطلبات";
require_once 'config/config.php';
/** @var array<string, array{class: string, icon: string, label: string}> $status_map */
$status_map = $GLOBALS['status_map'];
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

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
");

$orders->execute();
$orders = $orders->fetchAll(PDO::FETCH_OBJ);

?>

<body>

  <?php include 'includes/admin-sidebar.php'; ?>
  <main class="admin-content">
    <div class="admin-header">
      <div>
        <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
          <i class="bi bi-list" style="font-size:1.25rem;"></i>
        </button>
        <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">إدارة الطلبات</h1>
      </div>
    </div>

    <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label-custom">بحث</label>
          <input type="text" class="form-control form-control-custom" placeholder="رقم الطلب أو اسم العميل ..." id="adminOrderSearch">
        </div>
        <div class="col-md-3">
          <label class="form-label-custom">الحالة</label>
          <select class="form-select form-select-custom" id="adminOrderStatus">
            <option value="">الكل</option>
            <?php foreach ($status_map as $status_key => $status): ?>
              <option value="<?php echo $status_key; ?>"><?php echo htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label-custom">التاريخ</label>
          <input type="date" class="form-control form-control-custom" id="adminOrderDate">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-custom w-100" id="adminOrderFilterBtn">
            <i class="bi bi-funnel me-1"></i>تصفية
          </button>
        </div>
      </div>
    </div>

    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div class="table-responsive">
        <table class="table table-custom mb-0" id="adminOrdersTable">
          <thead>
            <tr>
              <th>رقم الطلب</th>
              <th>العميل</th>
              <th>المنتجات</th>
              <th>الإجمالي</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <?php
              $order_status = $status_map[$order->status] ?? [
                'class' => 'status-pending',
                'icon' => 'bi-question-circle-fill',
                'label' => $order->status
              ];
              ?>
              <tr>
                <td><strong>#ORD-<?php echo $order->order_id; ?></strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);"><?php echo $order->full_name[0]; ?></div>
                    <span><?php echo $order->full_name; ?></span>
                  </div>
                </td>
                <td><?php echo $order->total_items; ?> منتج</td>
                <td><strong><?php echo $order->total_amount; ?> ش</strong></td>
                <td><?php echo $order->order_date; ?></td>
                <td><span class="status-badge <?php echo $order_status['class']; ?>"><i class="bi <?php echo $order_status['icon']; ?>"></i> <?php echo htmlspecialchars($order_status['label'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <?php foreach ($status_map as $status_key => $status): ?>
                      <option value="<?php echo $status_key; ?>" <?php echo $order->status === $status_key ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($status['label'], ENT_QUOTES, 'UTF-8'); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
      <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عرض 1 إلى 6 من 1,248 طلب</p>
      <nav>
        <ul class="pagination mb-0" style="gap:4px;">
          <li class="page-item disabled"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a></li>
          <li class="page-item active"><a class="page-link border-0 rounded-3" href="#" style="background:var(--color-primary);border-color:var(--color-primary);">1</a></li>
          <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">2</a></li>
          <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">3</a></li>
          <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a></li>
        </ul>
      </nav>
    </div>
  </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>