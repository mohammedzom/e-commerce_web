<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="إدارة الرسائل — عرض وإدارة رسائل الزوار والعملاء.">
  <title>متجرنا — إدارة الرسائل</title>
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
        <li class="nav-item"><a href="admin_orders.php" class="nav-link"><i class="bi bi-receipt"></i> الطلبات</a></li>
        <li class="nav-item"><a href="admin_users.php" class="nav-link"><i class="bi bi-people"></i> المستخدمين</a></li>
        <li class="nav-item"><a href="admin_messages.php" class="nav-link active"><i class="bi bi-chat-dots"></i> الرسائل</a></li>
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
          <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">
            إدارة الرسائل
            <span class="status-badge status-pending" style="font-size:var(--font-size-xs);vertical-align:middle;">18 جديدة</span>
          </h1>
        </div>
        <button class="btn btn-outline-custom btn-sm-custom" id="markAllReadBtn">
          <i class="bi bi-check-all me-1"></i>تحديد الكل كمقروء
        </button>
      </div>

      <!-- Filters -->
      <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
        <div class="row g-3 align-items-end">
          <div class="col-md-5">
            <label class="form-label-custom">بحث</label>
            <input type="text" class="form-control form-control-custom" placeholder="الاسم أو البريد أو الموضوع ..." id="adminMsgSearch">
          </div>
          <div class="col-md-3">
            <label class="form-label-custom">الحالة</label>
            <select class="form-select form-select-custom" id="adminMsgStatus">
              <option>الكل</option>
              <option>غير مقروءة</option>
              <option>مقروءة</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label-custom">التاريخ</label>
            <input type="date" class="form-control form-control-custom" id="adminMsgDate">
          </div>
          <div class="col-md-2">
            <button class="btn btn-outline-custom w-100" id="adminMsgFilterBtn">
              <i class="bi bi-funnel me-1"></i>تصفية
            </button>
          </div>
        </div>
      </div>

      <!-- Messages Table -->
      <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
        <div class="table-responsive">
          <table class="table table-custom mb-0" id="adminMessagesTable">
            <thead>
              <tr>
                <th style="width:4%;">
                  <input class="form-check-input" type="checkbox" id="selectAllMsgs" style="cursor:pointer;">
                </th>
                <th>المرسل</th>
                <th>البريد الإلكتروني</th>
                <th>الموضوع</th>
                <th>مقتطف الرسالة</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <!-- Unread Message 1 -->
              <tr style="background-color:var(--color-primary-ultra-light);">
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);background:var(--color-primary-light);">ع</div>
                    <strong>عبدالله أحمد</strong>
                  </div>
                </td>
                <td>abdullah@mail.com</td>
                <td><strong>استفسار عن الشحن</strong></td>
                <td style="color:var(--color-text-secondary);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  أود معرفة تفاصيل الشحن للمنطقة الشرقية وهل يمكن ...
                </td>
                <td style="white-space:nowrap;">21 مايو 2026</td>
                <td><span class="status-badge status-pending"><i class="bi bi-envelope-fill"></i> غير مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-success-soft" title="تحديد كمقروء"><i class="bi bi-check2"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <!-- Unread Message 2 -->
              <tr style="background-color:var(--color-primary-ultra-light);">
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);background:var(--color-primary-light);">ل</div>
                    <strong>ليلى محمد</strong>
                  </div>
                </td>
                <td>laila@mail.com</td>
                <td><strong>مشكلة في الطلب</strong></td>
                <td style="color:var(--color-text-secondary);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  طلبي رقم #ORD-1040 وصل بمنتج مختلف عن الذي طلبته ...
                </td>
                <td style="white-space:nowrap;">21 مايو 2026</td>
                <td><span class="status-badge status-pending"><i class="bi bi-envelope-fill"></i> غير مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-success-soft" title="تحديد كمقروء"><i class="bi bi-check2"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <!-- Unread Message 3 -->
              <tr style="background-color:var(--color-primary-ultra-light);">
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);background:var(--color-primary-light);">ر</div>
                    <strong>راشد سعيد</strong>
                  </div>
                </td>
                <td>rashed@mail.com</td>
                <td><strong>اقتراح تحسين</strong></td>
                <td style="color:var(--color-text-secondary);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  أقترح إضافة خاصية تتبع الطلبات بشكل مفصل حتى يتمكن ...
                </td>
                <td style="white-space:nowrap;">20 مايو 2026</td>
                <td><span class="status-badge status-pending"><i class="bi bi-envelope-fill"></i> غير مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-success-soft" title="تحديد كمقروء"><i class="bi bi-check2"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <!-- Read Message 1 -->
              <tr>
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">م</div>
                    <span>محمد خالد</span>
                  </div>
                </td>
                <td>m.khaled@mail.com</td>
                <td>شكر وتقدير</td>
                <td style="color:var(--color-text-muted);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  أشكركم على الخدمة الممتازة والشحن السريع جداً ...
                </td>
                <td style="white-space:nowrap;">19 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-envelope-open"></i> مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <!-- Read Message 2 -->
              <tr>
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">هـ</div>
                    <span>هند عبدالعزيز</span>
                  </div>
                </td>
                <td>hind@mail.com</td>
                <td>استفسار عن المقاسات</td>
                <td style="color:var(--color-text-muted);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  هل يتوفر لديكم جدول مقاسات للأحذية الرياضية ...
                </td>
                <td style="white-space:nowrap;">18 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-envelope-open"></i> مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <!-- Read Message 3 -->
              <tr>
                <td><input class="form-check-input" type="checkbox" style="cursor:pointer;"></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="profile-avatar" style="width:32px;height:32px;font-size:var(--font-size-xs);">ص</div>
                    <span>صالح العمري</span>
                  </div>
                </td>
                <td>saleh@mail.com</td>
                <td>طلب توفير منتج</td>
                <td style="color:var(--color-text-muted);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  هل بالإمكان توفير سماعات من نوع AirPods Max ...
                </td>
                <td style="white-space:nowrap;">17 مايو 2026</td>
                <td><span class="status-badge status-completed"><i class="bi bi-envelope-open"></i> مقروءة</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عرض 1 إلى 6 من 45 رسالة</p>
        <nav>
          <ul class="pagination mb-0" style="gap:4px;">
            <li class="page-item disabled"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a></li>
            <li class="page-item active"><a class="page-link border-0 rounded-3" href="#" style="background:var(--color-primary);border-color:var(--color-primary);">1</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">2</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a></li>
          </ul>
        </nav>
      </div>
    </main>
  </div>

  <!-- MESSAGE DETAIL MODAL -->
  <div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border:none;border-radius:var(--radius-xl);">
        <div class="modal-header" style="border-bottom:1px solid var(--color-border-light);padding:var(--space-xl);">
          <h5 class="modal-title" style="font-weight:700;">
            <i class="bi bi-envelope-open ms-2 text-primary-custom"></i>تفاصيل الرسالة
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="padding:var(--space-xl);">
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">ع</div>
                <div>
                  <h6 style="font-weight:600;margin-bottom:0;">عبدالله أحمد</h6>
                  <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">abdullah@mail.com</span>
                </div>
              </div>
              <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">21 مايو 2026</span>
            </div>
          </div>
          <div style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);">
            <h6 style="font-weight:600;margin-bottom:var(--space-sm);">الموضوع: استفسار عن الشحن</h6>
            <p style="font-size:var(--font-size-sm);color:var(--color-text-secondary);line-height:1.9;">
              أود معرفة تفاصيل الشحن للمنطقة الشرقية وهل يمكن توفير شحن سريع خلال يومين؟ وما هي تكلفة الشحن للطلبات التي تقل عن 200 ريال؟ شكراً لكم.
            </p>
          </div>
        </div>
        <div class="modal-footer" style="border-top:1px solid var(--color-border-light);padding:var(--space-lg) var(--space-xl);">
          <button type="button" class="btn btn-danger-soft" data-bs-dismiss="modal">
            <i class="bi bi-trash3 me-1"></i>حذف
          </button>
          <button type="button" class="btn btn-primary-custom">
            <i class="bi bi-reply me-1"></i>رد عبر البريد
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
