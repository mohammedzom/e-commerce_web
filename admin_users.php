<?php
$page_description = 'إدارة المستخدمين — عرض وتعديل صلاحيات المستخدمين في المتجر.';
$page_title = 'متجرنا — إدارة المستخدمين';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';
$user_id = $_SESSION['user_id'] ?? 0;
$users = $conn->prepare("
  SELECT u.*, COUNT(o.order_id) as total_orders 
  FROM users u 
  LEFT JOIN orders o ON u.user_id = o.user_id 
  WHERE u.user_id != :user_id 
  GROUP BY u.user_id
  ORDER BY u.created_at DESC
");
$users->execute(['user_id' => $user_id]);
$users = $users->fetchAll(PDO::FETCH_OBJ);
?>

<body>

  <?php include 'includes/admin-sidebar.php'; ?>

  <main class="admin-content">
    <div class="admin-header">
      <div>
        <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
          <i class="bi bi-list" style="font-size:1.25rem;"></i>
        </button>
        <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">إدارة المستخدمين</h1>
      </div>
    </div>

    <!-- Filters -->
    <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
      <div class="row g-3 align-items-end">
        <div class="col-md-5">
          <label class="form-label-custom">بحث</label>
          <input type="text" class="form-control form-control-custom" placeholder="اسم المستخدم أو البريد الإلكتروني ..." id="adminUserSearch">
        </div>
        <div class="col-md-3">
          <label class="form-label-custom">الصلاحية</label>
          <select class="form-select form-select-custom" id="adminUserRole">
            <option>الكل</option>
            <option>مدير</option>
            <option>عميل</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label-custom">الحالة</label>
          <select class="form-select form-select-custom" id="adminUserStatus">
            <option>الكل</option>
            <option>نشط</option>
            <option>معطل</option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-custom w-100" id="adminUserFilterBtn">
            <i class="bi bi-funnel me-1"></i>تصفية
          </button>
        </div>
      </div>
    </div>

    <!-- Desktop Table -->
    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div class="table-responsive">
        <table class="table table-custom mb-0" id="adminUsersTable">
          <thead>
            <tr>
              <th>#</th>
              <th>المستخدم</th>
              <th>البريد الإلكتروني</th>
              <th class="col-hide-xl">الجوال</th>
              <th class="col-hide-xl">تاريخ التسجيل</th>
              <th>الطلبات</th>
              <th>الصلاحية</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user) {
              $first_letter = mb_substr(trim($user->full_name), 0, 1, 'UTF-8');
            ?>
              <tr>
                <td data-label="#"> <?= htmlspecialchars($user->user_id) ?></td>
                <td data-label="المستخدم">
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);"><?= htmlspecialchars($first_letter) ?></div>
                    <strong><?= htmlspecialchars($user->full_name) ?></strong>
                  </div>
                </td>
                <td data-label="البريد الإلكتروني"><?= htmlspecialchars($user->email) ?></td>
                <td data-label="الجوال" class="col-hide-xl" dir="ltr" style="text-align:right;"><?= htmlspecialchars($user->phone ?: '-') ?></td>
                <td data-label="تاريخ التسجيل" class="col-hide-xl"><?= date('Y-m-d', strtotime($user->created_at)) ?></td>
                <td data-label="الطلبات"><?= htmlspecialchars($user->total_orders) ?></td>
                <td data-label="الصلاحية">
                  <form action="<?= APPURL ?>actions/update_user_role.php" method="POST" style="margin:0;">
                    <input type="hidden" name="user_id" value="<?= $user->user_id ?>">
                    <select name="role" class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;" onchange="this.form.submit()">
                      <option value="customer" <?= $user->role == 'customer' ? 'selected' : '' ?>>عميل</option>
                      <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>مدير</option>
                    </select>
                  </form>
                </td>
                <td data-label="الإجراءات">
                  <div class="d-flex gap-1 justify-content-end">
                    <form action="<?= APPURL ?>actions/delete_user.php" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم نهائياً؟');" style="margin:0;">
                      <input type="hidden" name="del_id" value="<?= $user->user_id ?>">
                      <button type="submit" class="btn btn-danger-soft btn-sm-custom" title="حذف المستخدم"><i class="bi bi-trash3"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
      <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);" id="adminUsersPaginationInfo">عرض 1 إلى 6 من 6 مستخدم</p>
      <nav>
        <ul class="pagination mb-0" id="adminUsersPagination" style="gap:4px;"></ul>
      </nav>
    </div>
  </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL; ?>js/main.js"></script>
  <script src="<?php echo APPURL; ?>js/admin_users.js"></script>
</body>

</html>