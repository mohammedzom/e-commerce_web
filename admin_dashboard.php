<?php
$page_description = "لوحة التحكم — إدارة المتجر ومتابعة الإحصائيات.";
$page_title = "متجرنا — لوحة التحكم";
include 'includes/header.php';
?>

  <div class="admin-wrapper">
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:999;"></div>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand">
        <a href="index.php" style="color:inherit;text-decoration:none;">
          <i class="bi bi-bag-heart"></i> متجر<span>نا</span>
        </a>
      </div>

      <ul class="sidebar-nav">
        <li class="nav-label">القائمة الرئيسية</li>
        <li class="nav-item">
          <a href="admin_dashboard.php" class="nav-link active">
            <i class="bi bi-grid-1x2"></i> لوحة التحكم
          </a>
        </li>
        <li class="nav-item">
          <a href="admin_products.php" class="nav-link">
            <i class="bi bi-box-seam"></i> المنتجات
          </a>
        </li>
        <li class="nav-item">
          <a href="admin_orders.php" class="nav-link">
            <i class="bi bi-receipt"></i> الطلبات
          </a>
        </li>
        <li class="nav-item">
          <a href="admin_users.php" class="nav-link">
            <i class="bi bi-people"></i> المستخدمين
          </a>
        </li>
        <li class="nav-item">
          <a href="admin_messages.php" class="nav-link">
            <i class="bi bi-chat-dots"></i> الرسائل
          </a>
        </li>

        <li class="nav-label" style="margin-top:var(--space-lg);">إعدادات</li>
        <li class="nav-item">
          <a href="admin_settings.php" class="nav-link">
            <i class="bi bi-gear"></i> إعدادات الموقع
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="bi bi-house"></i> عرض الموقع
          </a>
        </li>
        <li class="nav-item" style="margin-top:auto;">
          <a href="<?php echo APPURL; ?>auth/logout.php" class="nav-link" style="color:var(--color-danger);">
            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
          </a>
        </li>
      </ul>
    </aside>

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
        <div class="d-flex align-items-center gap-3">
          <button class="nav-icon-btn" style="position:relative;">
            <i class="bi bi-bell"></i>
            <span class="badge-dot"></span>
          </button>
          <div class="d-flex align-items-center gap-2">
            <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-sm);">م</div>
            <span style="font-size:var(--font-size-sm);font-weight:600;">المدير</span>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon bg-primary-light text-primary-custom">
              <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-value">524</div>
            <div class="stat-label">إجمالي المنتجات</div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon bg-success-light text-success-custom">
              <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-label">إجمالي الطلبات</div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon bg-info-light" style="color:var(--color-info);">
              <i class="bi bi-people"></i>
            </div>
            <div class="stat-value">3,067</div>
            <div class="stat-label">إجمالي المستخدمين</div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon bg-warning-light text-warning-custom">
              <i class="bi bi-chat-dots"></i>
            </div>
            <div class="stat-value">18</div>
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
                  <tr>
                    <td><strong>#ORD-1048</strong></td>
                    <td>أحمد محمد</td>
                    <td>850 ر.س</td>
                    <td><span class="status-badge status-pending"><i class="bi bi-clock"></i> قيد الانتظار</span></td>
                    <td>21 مايو 2026</td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1047</strong></td>
                    <td>سارة علي</td>
                    <td>1,200 ر.س</td>
                    <td><span class="status-badge status-processing"><i class="bi bi-arrow-repeat"></i> قيد التنفيذ</span></td>
                    <td>21 مايو 2026</td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1046</strong></td>
                    <td>خالد عبدالله</td>
                    <td>349 ر.س</td>
                    <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                    <td>20 مايو 2026</td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1045</strong></td>
                    <td>نورة سعد</td>
                    <td>1,375 ر.س</td>
                    <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                    <td>20 مايو 2026</td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1044</strong></td>
                    <td>فهد الرشيدي</td>
                    <td>699 ر.س</td>
                    <td><span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> ملغي</span></td>
                    <td>19 مايو 2026</td>
                  </tr>
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
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                  <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=60&h=60&fit=crop" alt="سماعات" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">سماعات لاسلكية</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">156 مبيعة</span>
                </div>
                <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);">349 ر.س</span>
              </div>
              <!-- Top Product 2 -->
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                  <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60&h=60&fit=crop" alt="ساعة" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">ساعة يد كلاسيكية</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">128 مبيعة</span>
                </div>
                <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);">299 ر.س</span>
              </div>
              <!-- Top Product 3 -->
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                  <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=60&h=60&fit=crop" alt="حذاء" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">حذاء رياضي</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">98 مبيعة</span>
                </div>
                <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);">199 ر.س</span>
              </div>
              <!-- Top Product 4 -->
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                  <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=60&h=60&fit=crop" alt="عطر" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">عطر فاخر فرنسي</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">87 مبيعة</span>
                </div>
                <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);">280 ر.س</span>
              </div>
              <!-- Top Product 5 -->
              <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                  <img src="https://images.unsplash.com/photo-1546868871-af0de0ae72be?w=60&h=60&fit=crop" alt="ساعة ذكية" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">ساعة ذكية</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">76 مبيعة</span>
                </div>
                <span style="font-size:var(--font-size-sm);font-weight:600;color:var(--color-primary);">699 ر.س</span>
              </div>
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
