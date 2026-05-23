<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="إدارة الطلبات — متابعة وتحديث حالة الطلبات في المتجر.">
  <title>متجرنا — إدارة الطلبات</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="admin-wrapper">
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:999;"></div>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand">
        <a href="index.php" style="color:inherit;text-decoration:none;"><i class="bi bi-bag-heart"></i> متجر<span>نا</span></a>
      </div>
      <ul class="sidebar-nav">
        <li class="nav-label">القائمة الرئيسية</li>
        <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><i class="bi bi-grid-1x2"></i> لوحة التحكم</a></li>
        <li class="nav-item"><a href="admin_products.php" class="nav-link"><i class="bi bi-box-seam"></i> المنتجات</a></li>
        <li class="nav-item"><a href="admin_orders.php" class="nav-link active"><i class="bi bi-receipt"></i> الطلبات</a></li>
        <li class="nav-item"><a href="admin_users.php" class="nav-link"><i class="bi bi-people"></i> المستخدمين</a></li>
        <li class="nav-item"><a href="admin_messages.php" class="nav-link"><i class="bi bi-chat-dots"></i> الرسائل</a></li>
        <li class="nav-label" style="margin-top:var(--space-lg);">إعدادات</li>
        <li class="nav-item"><a href="admin_settings.php" class="nav-link"><i class="bi bi-gear"></i> إعدادات الموقع</a></li>
        <li class="nav-item"><a href="index.php" class="nav-link"><i class="bi bi-house"></i> عرض الموقع</a></li>
        <li class="nav-item"><a href="login.php" class="nav-link" style="color:var(--color-danger);"><i class="bi bi-box-arrow-right"></i> تسجيل الخروج</a></li>
      </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-content">
      <div class="admin-header">
        <div>
          <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
            <i class="bi bi-list" style="font-size:1.25rem;"></i>
          </button>
          <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">إدارة الطلبات</h1>
        </div>
      </div>

      <!-- Filters -->
      <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
        <div class="row g-3 align-items-end">
          <div class="col-md-4">
            <label class="form-label-custom">بحث</label>
            <input type="text" class="form-control form-control-custom" placeholder="رقم الطلب أو اسم العميل ..." id="adminOrderSearch">
          </div>
          <div class="col-md-3">
            <label class="form-label-custom">الحالة</label>
            <select class="form-select form-select-custom" id="adminOrderStatus">
              <option>الكل</option>
              <option>قيد الانتظار</option>
              <option>قيد التنفيذ</option>
              <option>مكتمل</option>
              <option>ملغي</option>
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

      <!-- Orders Table -->
      <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
        <div class="table-responsive">
          <table class="table table-custom mb-0" id="adminOrdersTable">
            <thead>
              <tr>
                <th>رقم الطلب</th>
                <th>العميل</th>
                <th>المنتجات</th>
                <th>الإجمالي</th>
                <th>طريقة الدفع</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>#ORD-1048</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">أ</div>
                    <span>أحمد محمد</span>
                  </div>
                </td>
                <td>2 منتج</td>
                <td><strong>850 ر.س</strong></td>
                <td>بطاقة ائتمان</td>
                <td>21 مايو 2026</td>
                <td><span class="status-badge status-pending"><i class="bi bi-clock"></i> قيد الانتظار</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option selected>قيد الانتظار</option>
                    <option>قيد التنفيذ</option>
                    <option>مكتمل</option>
                    <option>ملغي</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><strong>#ORD-1047</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">س</div>
                    <span>سارة علي</span>
                  </div>
                </td>
                <td>3 منتجات</td>
                <td><strong>1,200 ر.س</strong></td>
                <td>تحويل بنكي</td>
                <td>21 مايو 2026</td>
                <td><span class="status-badge status-processing"><i class="bi bi-arrow-repeat"></i> قيد التنفيذ</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option>قيد الانتظار</option>
                    <option selected>قيد التنفيذ</option>
                    <option>مكتمل</option>
                    <option>ملغي</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><strong>#ORD-1046</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">خ</div>
                    <span>خالد عبدالله</span>
                  </div>
                </td>
                <td>1 منتج</td>
                <td><strong>349 ر.س</strong></td>
                <td>بطاقة ائتمان</td>
                <td>20 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option>قيد الانتظار</option>
                    <option>قيد التنفيذ</option>
                    <option selected>مكتمل</option>
                    <option>ملغي</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><strong>#ORD-1045</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">ن</div>
                    <span>نورة سعد</span>
                  </div>
                </td>
                <td>3 منتجات</td>
                <td><strong>1,375 ر.س</strong></td>
                <td>الدفع عند الاستلام</td>
                <td>20 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option>قيد الانتظار</option>
                    <option>قيد التنفيذ</option>
                    <option selected>مكتمل</option>
                    <option>ملغي</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><strong>#ORD-1044</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">ف</div>
                    <span>فهد الرشيدي</span>
                  </div>
                </td>
                <td>1 منتج</td>
                <td><strong>699 ر.س</strong></td>
                <td>بطاقة ائتمان</td>
                <td>19 مايو 2026</td>
                <td><span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> ملغي</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option>قيد الانتظار</option>
                    <option>قيد التنفيذ</option>
                    <option>مكتمل</option>
                    <option selected>ملغي</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><strong>#ORD-1043</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">ع</div>
                    <span>عبدالرحمن سعيد</span>
                  </div>
                </td>
                <td>4 منتجات</td>
                <td><strong>2,100 ر.س</strong></td>
                <td>تحويل بنكي</td>
                <td>18 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                <td>
                  <select class="form-select form-select-custom" style="width:auto;min-width:130px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                    <option>قيد الانتظار</option>
                    <option>قيد التنفيذ</option>
                    <option selected>مكتمل</option>
                    <option>ملغي</option>
                  </select>
                </td>
              </tr>
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
