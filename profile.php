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
    "January" => "يناير",
    "February" => "فبراير",
    "March" => "مارس",
    "April" => "أبريل",
    "May" => "مايو",
    "June" => "يونيو",
    "July" => "يوليو",
    "August" => "أغسطس",
    "September" => "سبتمبر",
    "October" => "أكتوبر",
    "November" => "نوفمبر",
    "December" => "ديسمبر"
);

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
");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
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
                            <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عميل منذ <?php echo $months_list_ar[date('M', strtotime($user->created_at))] . ' ' . date('Y', strtotime($user->created_at))  ?></p>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "includes/footer.php"; ?>
