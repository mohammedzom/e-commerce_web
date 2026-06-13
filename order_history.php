<?php
$page_title = 'متجرنا — سجل الطلبات';
$page_description = 'سجل الطلبات الخاصة بك.';
require __DIR__ . '/config/config.php';
require __DIR__ . '/includes/middleware/check-login.php';
include __DIR__ . '/includes/header.php';

$user_id = $_SESSION['user_id'];
$orders_per_page = 10;
$total_orders_stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :user_id");
$total_orders_stmt->execute(['user_id' => $user_id]);
$total_orders = (int) $total_orders_stmt->fetchColumn();
$total_pages = max(1, (int) ceil($total_orders / $orders_per_page));
$current_page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

if ($current_page > $total_pages) {
  $current_page = $total_pages;
}

$offset = ($current_page - 1) * $orders_per_page;
$start_order = $total_orders > 0 ? $offset + 1 : 0;
$end_order = min($offset + $orders_per_page, $total_orders);

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
  LIMIT :limit OFFSET :offset
");
$orders->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$orders->bindValue(':limit', $orders_per_page, PDO::PARAM_INT);
$orders->bindValue(':offset', $offset, PDO::PARAM_INT);
$orders->execute();
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
      <?= displayFlash() ?>
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
	      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
	        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">
	          عرض <?php echo $start_order; ?> إلى <?php echo $end_order; ?> من <?php echo $total_orders; ?> طلب
	        </p>

	        <?php if ($total_pages > 1): ?>
	          <nav>
	            <?php
	            $page_get = $_GET;
	            unset($page_get['page']);
	            $base_q = http_build_query($page_get);
	            $base_url = 'order_history.php?' . ($base_q ? $base_q . '&' : '');
	            $max_visible = 5;
	            $start_page = max(1, $current_page - floor($max_visible / 2));
	            $end_page = min($total_pages, $start_page + $max_visible - 1);
	            $start_page = max(1, $end_page - $max_visible + 1);
	            ?>
	            <ul class="pagination mb-0" style="gap:4px;">
	              <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
	                <a class="page-link border-0 rounded-3" href="<?php echo ($current_page > 1) ? $base_url . 'page=' . ($current_page - 1) : '#'; ?>" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a>
	              </li>

	              <?php if ($start_page > 1): ?>
	                <li class="page-item">
	                  <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=1" style="color:var(--color-text-secondary);">1</a>
	                </li>
	                <?php if ($start_page > 2): ?>
	                  <li class="page-item disabled">
	                    <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
	                  </li>
	                <?php endif; ?>
	              <?php endif; ?>

	              <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
	                <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
	                  <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $i; ?>" style="<?php echo ($i === $current_page) ? 'background:var(--color-primary);border-color:var(--color-primary);' : 'color:var(--color-text-secondary);'; ?>"><?php echo $i; ?></a>
	                </li>
	              <?php endfor; ?>

	              <?php if ($end_page < $total_pages): ?>
	                <?php if ($end_page < $total_pages - 1): ?>
	                  <li class="page-item disabled">
	                    <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
	                  </li>
	                <?php endif; ?>
	                <li class="page-item">
	                  <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $total_pages; ?>" style="color:var(--color-text-secondary);"><?php echo $total_pages; ?></a>
	                </li>
	              <?php endif; ?>

	              <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
	                <a class="page-link border-0 rounded-3" href="<?php echo ($current_page < $total_pages) ? $base_url . 'page=' . ($current_page + 1) : '#'; ?>" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a>
	              </li>
	            </ul>
	          </nav>
	        <?php endif; ?>
	      </div>
	    </div>
	  </section>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>
