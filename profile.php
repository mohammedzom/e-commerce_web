<?php
$page_description = 'الملف الشخصي — تعديل بياناتك وعرض سجل طلباتك في متجرنا.';
$page_title = 'متجرنا — الملف الشخصي';
require_once 'config/config.php';
require_once 'includes/middleware/check-login.php';
include 'includes/header.php';

$user = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
$user->execute(['user_id' => $_SESSION['user_id']]);
$user = $user->fetch(PDO::FETCH_OBJ);

$months_list_ar = array(
    "01" => "يناير",
    "02" => "فبراير",
    "03" => "مارس",
    "04" => "أبريل",
    "05" => "مايو",
    "06" => "يونيو",
    "07" => "يوليو",
    "08" => "أغسطس",
    "09" => "سبتمبر",
    "10" => "أكتوبر",
    "11" => "نوفمبر",
    "12" => "ديسمبر"
);

$orders_per_page = 5;
$total_orders_stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :user_id");
$total_orders_stmt->execute(['user_id' => $_SESSION['user_id']]);
$total_orders = (int) $total_orders_stmt->fetchColumn();
$total_pages = max(1, (int) ceil($total_orders / $orders_per_page));
$current_page = isset($_GET['orders_page']) ? max(1, (int) $_GET['orders_page']) : 1;

if ($current_page > $total_pages) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $orders_per_page;
$start_order = $total_orders > 0 ? $offset + 1 : 0;
$end_order = min($offset + $orders_per_page, $total_orders);

$stmt = $conn->prepare("
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
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':limit', $orders_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1>الملف الشخصي</h1>
            <div class="breadcrumb-custom">
                <a href="index.php">الرئيسية</a>
                <span class="separator">/</span>
                <span>الملف الشخصي</span>
            </div>
        </div>
    </div>

    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-xl);">
                        <div class="text-center mb-4">
                            <div class="profile-avatar mx-auto mb-3"><?php echo $user->full_name[0] ?></div>
                            <h5 style="font-weight:700;margin-bottom:2px;"><?php echo $user->full_name ?></h5>
                            <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عميل منذ <?= $months_list_ar[date('m', strtotime($user->created_at))] . ' ' . date('Y', strtotime($user->created_at))  ?></p>
                        </div>

                        <ul class="nav flex-column gap-1" id="profileTabs">
                            <li>
                                <a href="<?php echo APPURL; ?>profile.php" class="nav-link d-flex align-items-center gap-2 active" style="color:var(--color-primary);background:var(--color-primary-ultra-light);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-person"></i> البيانات الشخصية
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo APPURL; ?>order_history.php" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-bag"></i> سجل الطلبات
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo APPURL; ?>change_password.php" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-lock"></i> تغيير كلمة المرور
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card-custom" style="padding:var(--space-2xl);border-radius:var(--radius-xl);margin-bottom:var(--space-xl);">
                        <h5 style="font-weight:700;margin-bottom:var(--space-lg);">
                            <i class="bi bi-person-gear ms-2 text-primary-custom"></i>
                            البيانات الشخصية
                        </h5>
                        <form method="post" action="<?php echo APPURL; ?>actions/update_profile.php">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label-custom" for="profileFirstName">الاسم</label>
                                    <input type="text" class="form-control form-control-custom" id="profileFirstName" name="name" value="<?php echo $user->full_name; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom" for="profileEmail">البريد الإلكتروني</label>
                                    <input type="email" class="form-control form-control-custom" id="profileEmail" name="email" value="<?php echo $user->email; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom" for="profilePhone">رقم الجوال</label>
                                    <input type="tel" class="form-control form-control-custom" id="profilePhone" name="phone" value="<?php echo $user->phone; ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom" for="profileAddress">العنوان</label>
                                    <textarea class="form-control form-control-custom" id="profileAddress" name="address" rows="3"><?php echo $user->address; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="update_profile" class="btn btn-primary-custom">
                                        <i class="bi bi-check-lg me-2"></i>حفظ التغييرات
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-custom" style="padding:var(--space-2xl);border-radius:var(--radius-xl);">
                        <h5 style="font-weight:700;margin-bottom:var(--space-lg);">
                            <i class="bi bi-clock-history ms-2 text-primary-custom"></i>
                            سجل الطلبات
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0" id="orderHistoryTable">
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
                                    <?php foreach ($orders as $order) : ?>
                                        <?php
                                        $order_status = strtolower((string) $order->status);
                                        $status = $status_map[$order_status] ?? [
                                            'class' => 'status-processing',
                                            'icon' => 'bi-info-circle-fill',
                                            'label' => $order->status
                                        ];
                                        ?>
                                        <tr>
                                            <td><strong>#ORD-<?php echo $order->order_id ?></strong></td>
                                            <td><?php echo date('Y-m-d', strtotime($order->order_date)) ?></td>
                                            <td><?php echo (int) $order->total_items ?> منتجات</td>
                                            <td><?php echo number_format((float) $order->total_amount, 2) ?> ش</td>
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
                        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                            <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">
                                عرض <?php echo $start_order; ?> إلى <?php echo $end_order; ?> من <?php echo $total_orders; ?> طلب
                            </p>

                            <?php if ($total_pages > 1): ?>
                                <nav>
                                    <?php
                                    $page_get = $_GET;
                                    unset($page_get['orders_page']);
                                    $base_q = http_build_query($page_get);
                                    $base_url = 'profile.php?' . ($base_q ? $base_q . '&' : '');
                                    $max_visible = 5;
                                    $start_page = max(1, $current_page - floor($max_visible / 2));
                                    $end_page = min($total_pages, $start_page + $max_visible - 1);
                                    $start_page = max(1, $end_page - $max_visible + 1);
                                    ?>
                                    <ul class="pagination mb-0" style="gap:4px;">
                                        <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link border-0 rounded-3" href="<?php echo ($current_page > 1) ? $base_url . 'orders_page=' . ($current_page - 1) : '#'; ?>" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a>
                                        </li>

                                        <?php if ($start_page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>orders_page=1" style="color:var(--color-text-secondary);">1</a>
                                            </li>
                                            <?php if ($start_page > 2): ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                            <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                                                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>orders_page=<?php echo $i; ?>" style="<?php echo ($i === $current_page) ? 'background:var(--color-primary);border-color:var(--color-primary);' : 'color:var(--color-text-secondary);'; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($end_page < $total_pages): ?>
                                            <?php if ($end_page < $total_pages - 1): ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
                                                </li>
                                            <?php endif; ?>
                                            <li class="page-item">
                                                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>orders_page=<?php echo $total_pages; ?>" style="color:var(--color-text-secondary);"><?php echo $total_pages; ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                            <a class="page-link border-0 rounded-3" href="<?php echo ($current_page < $total_pages) ? $base_url . 'orders_page=' . ($current_page + 1) : '#'; ?>" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>