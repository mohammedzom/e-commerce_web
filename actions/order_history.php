<?php
$page_title = 'متجرنا — سجل الطلبات';
$page_description = 'سجل الطلبات الخاصة بك.';
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/middleware/check-login.php';
include __DIR__ . '/../includes/header.php';

$user_id = $_SESSION['user_id'];
$orders = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
$orders->execute(['user_id' => $user_id]);
$orders = $orders->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <?php include __DIR__ . '/../includes/navbar.php'; ?>
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
        <?php if(count($orders) === 0): ?>
            <p>لا توجد طلبات سابقة.</p>
        <?php else: ?>
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>رقم الطلب</th>
                <th>التاريخ</th>
                <th>الإجمالي</th>
                <th>الحالة</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($orders as $order): ?>
              <tr>
                <td><strong>#ORD-<?php echo $order->order_id; ?></strong></td>
                <td><?php echo $order->order_date; ?></td>
                <td><?php echo $order->total_amount; ?> ش</td>
                <td><span class="status-badge status-<?php echo $order->status; ?>"><?php echo $order->status; ?></span></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
