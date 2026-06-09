<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="إدارة المستخدمين — عرض وتعديل صلاحيات المستخدمين في المتجر.">
  <title>متجرنا — إدارة المستخدمين</title>
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
        <li class="nav-item"><a href="admin_users.php" class="nav-link active"><i class="bi bi-people"></i> المستخدمين</a></li>
        <li class="nav-item"><a href="admin_messages.php" class="nav-link"><i class="bi bi-chat-dots"></i> الرسائل</a></li>
        <li class="nav-label" style="margin-top:var(--space-lg);">إعدادات</li>
        <li class="nav-item"><a href="admin_settings.php" class="nav-link"><i class="bi bi-gear"></i> إعدادات الموقع</a></li>
        <li class="nav-item"><a href="index.php" class="nav-link"><i class="bi bi-house"></i> عرض الموقع</a></li>
        <li class="nav-item"><a href="auth/logout.php" class="nav-link" style="color:var(--color-danger);"><i class="bi bi-box-arrow-right"></i> تسجيل الخروج</a></li>
      </ul>
    </aside>

    <!-- MAIN CONTENT -->
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

      <!-- Users Table (Desktop) / Cards (Mobile) -->
      <style>
        /* --- Users Table Responsive Styles --- */
        .users-table-desktop { display: block; }
        .users-cards-mobile  { display: none; }

        @media (max-width: 1199.98px) {
          .users-table-desktop .col-hide-xl { display: none !important; }
        }

        @media (max-width: 991.98px) {
          .users-table-desktop { display: none; }
          .users-cards-mobile  { display: block; }
        }

        /* --- Mobile User Card --- */
        .user-card-mobile {
          background: var(--color-white);
          border: 1px solid var(--color-border-light);
          border-radius: var(--radius-lg);
          padding: var(--space-lg);
          margin-bottom: var(--space-md);
          transition: box-shadow var(--transition-fast);
        }
        .user-card-mobile:hover {
          box-shadow: var(--shadow-sm);
        }
        .user-card-mobile .user-card-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: var(--space-md);
        }
        .user-card-mobile .user-card-meta {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: var(--space-sm) var(--space-lg);
          font-size: var(--font-size-sm);
          margin-bottom: var(--space-md);
        }
        .user-card-mobile .user-card-meta .meta-label {
          font-size: var(--font-size-xs);
          color: var(--color-text-muted);
          margin-bottom: 2px;
        }
        .user-card-mobile .user-card-meta .meta-value {
          color: var(--color-text);
          font-weight: 500;
        }
        .user-card-mobile .user-card-footer {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: var(--space-sm);
          padding-top: var(--space-md);
          border-top: 1px solid var(--color-border-light);
          flex-wrap: wrap;
        }

        @media (max-width: 479.98px) {
          .user-card-mobile .user-card-meta {
            grid-template-columns: 1fr;
          }
        }
      </style>

      <!-- Desktop Table -->
      <div class="users-table-desktop">
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
                  <th>الحالة</th>
                  <th>الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">أ</div>
                      <strong>أحمد محمد</strong>
                    </div>
                  </td>
                  <td>ahmed@mail.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 111 1111</td>
                  <td class="col-hide-xl">15 يناير 2026</td>
                  <td>12</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-danger-soft" title="تعطيل"><i class="bi bi-slash-circle"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">س</div>
                      <strong>سارة علي</strong>
                    </div>
                  </td>
                  <td>sara@mail.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 222 2222</td>
                  <td class="col-hide-xl">20 فبراير 2026</td>
                  <td>8</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-danger-soft" title="تعطيل"><i class="bi bi-slash-circle"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">خ</div>
                      <strong>خالد عبدالله</strong>
                    </div>
                  </td>
                  <td>khaled@mail.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 333 3333</td>
                  <td class="col-hide-xl">5 مارس 2026</td>
                  <td>3</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-danger-soft" title="تعطيل"><i class="bi bi-slash-circle"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">ن</div>
                      <strong>نورة سعد</strong>
                    </div>
                  </td>
                  <td>noura@mail.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 444 4444</td>
                  <td class="col-hide-xl">12 مارس 2026</td>
                  <td>15</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-danger-soft" title="تعطيل"><i class="bi bi-slash-circle"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">ف</div>
                      <strong>فهد الرشيدي</strong>
                    </div>
                  </td>
                  <td>fahad@mail.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 555 5555</td>
                  <td class="col-hide-xl">1 أبريل 2026</td>
                  <td>6</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> معطل</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-success-soft" title="تفعيل"><i class="bi bi-check-circle"></i></button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="profile-avatar" style="width:36px;height:36px;font-size:var(--font-size-xs);">م</div>
                      <strong>المدير العام</strong>
                    </div>
                  </td>
                  <td>admin@matjarna.com</td>
                  <td class="col-hide-xl" dir="ltr" style="text-align:right;">+966 50 000 0000</td>
                  <td class="col-hide-xl">1 يناير 2026</td>
                  <td>—</td>
                  <td>
                    <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.3rem 0.6rem;">
                      <option>عميل</option>
                      <option selected>مدير</option>
                    </select>
                  </td>
                  <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Mobile Cards -->
      <div class="users-cards-mobile">
        <!-- User 1 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">أ</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">أحمد محمد</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">ahmed@mail.com</div>
              </div>
            </div>
            <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 111 1111</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">15 يناير 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">12</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
            <button class="btn btn-danger-soft"><i class="bi bi-slash-circle me-1"></i>تعطيل</button>
          </div>
        </div>

        <!-- User 2 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">س</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">سارة علي</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">sara@mail.com</div>
              </div>
            </div>
            <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 222 2222</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">20 فبراير 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">8</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
            <button class="btn btn-danger-soft"><i class="bi bi-slash-circle me-1"></i>تعطيل</button>
          </div>
        </div>

        <!-- User 3 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">خ</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">خالد عبدالله</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">khaled@mail.com</div>
              </div>
            </div>
            <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 333 3333</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">5 مارس 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">3</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
            <button class="btn btn-danger-soft"><i class="bi bi-slash-circle me-1"></i>تعطيل</button>
          </div>
        </div>

        <!-- User 4 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">ن</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">نورة سعد</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">noura@mail.com</div>
              </div>
            </div>
            <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 444 4444</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">12 مارس 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">15</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
            <button class="btn btn-danger-soft"><i class="bi bi-slash-circle me-1"></i>تعطيل</button>
          </div>
        </div>

        <!-- User 5 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">ف</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">فهد الرشيدي</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">fahad@mail.com</div>
              </div>
            </div>
            <span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> معطل</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 555 5555</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">1 أبريل 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">6</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
            <button class="btn btn-success-soft"><i class="bi bi-check-circle me-1"></i>تفعيل</button>
          </div>
        </div>

        <!-- User 6 -->
        <div class="user-card-mobile">
          <div class="user-card-header">
            <div class="d-flex align-items-center gap-2">
              <div class="profile-avatar" style="width:40px;height:40px;font-size:var(--font-size-sm);">م</div>
              <div>
                <strong style="font-size:var(--font-size-sm);">المدير العام</strong>
                <div style="font-size:var(--font-size-xs);color:var(--color-text-muted);">admin@matjarna.com</div>
              </div>
            </div>
            <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> نشط</span>
          </div>
          <div class="user-card-meta">
            <div>
              <div class="meta-label">الجوال</div>
              <div class="meta-value" dir="ltr" style="text-align:right;">+966 50 000 0000</div>
            </div>
            <div>
              <div class="meta-label">تاريخ التسجيل</div>
              <div class="meta-value">1 يناير 2026</div>
            </div>
            <div>
              <div class="meta-label">الطلبات</div>
              <div class="meta-value">—</div>
            </div>
            <div>
              <div class="meta-label">الصلاحية</div>
              <div class="meta-value">
                <select class="form-select form-select-custom" style="width:auto;min-width:90px;font-size:var(--font-size-xs);padding:0.25rem 0.5rem;">
                  <option>عميل</option>
                  <option selected>مدير</option>
                </select>
              </div>
            </div>
          </div>
          <div class="user-card-footer">
            <button class="btn btn-outline-custom btn-sm-custom"><i class="bi bi-pencil me-1"></i>تعديل</button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);" id="adminUsersPaginationInfo">عرض 1 إلى 6 من 6 مستخدم</p>
        <nav>
          <ul class="pagination mb-0" id="adminUsersPagination" style="gap:4px;"></ul>
        </nav>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var rows = Array.prototype.slice.call(document.querySelectorAll('#adminUsersTable tbody tr'));
      var cards = Array.prototype.slice.call(document.querySelectorAll('.users-cards-mobile .user-card-mobile'));
      var info = document.getElementById('adminUsersPaginationInfo');
      var pagination = document.getElementById('adminUsersPagination');
      var pageSize = 6;
      var currentPage = 1;

      if (!pagination || rows.length === 0) return;

      function appendItem(label, pageNumber, options) {
        options = options || {};
        var item = document.createElement('li');
        item.className = 'page-item' + (options.disabled ? ' disabled' : '') + (options.active ? ' active' : '');

        var link = document.createElement('a');
        link.className = 'page-link border-0 rounded-3';
        link.href = '#';
        link.dataset.page = String(pageNumber);
        link.innerHTML = label;

        if (options.active) {
          link.style.background = 'var(--color-primary)';
          link.style.borderColor = 'var(--color-primary)';
        } else {
          link.style.color = options.disabled ? 'var(--color-text-muted)' : 'var(--color-text-secondary)';
        }

        item.appendChild(link);
        pagination.appendChild(item);
      }

      function appendEllipsis() {
        var item = document.createElement('li');
        item.className = 'page-item disabled';

        var span = document.createElement('span');
        span.className = 'page-link border-0 rounded-3';
        span.style.color = 'var(--color-text-muted)';
        span.textContent = '...';

        item.appendChild(span);
        pagination.appendChild(item);
      }

      function renderPagination(totalPages) {
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        var maxVisible = 5;
        var startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        var endPage = Math.min(totalPages, startPage + maxVisible - 1);
        startPage = Math.max(1, endPage - maxVisible + 1);

        appendItem('<i class="bi bi-chevron-right"></i>', currentPage - 1, { disabled: currentPage === 1 });

        if (startPage > 1) {
          appendItem('1', 1);
          if (startPage > 2) appendEllipsis();
        }

        for (var i = startPage; i <= endPage; i++) {
          appendItem(String(i), i, { active: i === currentPage });
        }

        if (endPage < totalPages) {
          if (endPage < totalPages - 1) appendEllipsis();
          appendItem(String(totalPages), totalPages);
        }

        appendItem('<i class="bi bi-chevron-left"></i>', currentPage + 1, { disabled: currentPage === totalPages });
      }

      function renderPage() {
        var totalItems = rows.length;
        var totalPages = Math.max(1, Math.ceil(totalItems / pageSize));
        currentPage = Math.min(currentPage, totalPages);

        var startIndex = (currentPage - 1) * pageSize;
        var endIndex = startIndex + pageSize;

        rows.forEach(function(row, index) {
          row.classList.toggle('d-none', index < startIndex || index >= endIndex);
        });

        cards.forEach(function(card, index) {
          card.classList.toggle('d-none', index < startIndex || index >= endIndex);
        });

        if (info) {
          info.textContent = 'عرض ' + (totalItems === 0 ? 0 : startIndex + 1) + ' إلى ' + Math.min(endIndex, totalItems) + ' من ' + totalItems + ' مستخدم';
        }

        renderPagination(totalPages);
      }

      pagination.addEventListener('click', function(event) {
        var link = event.target.closest('a[data-page]');
        event.preventDefault();
        if (!link || link.closest('.disabled')) return;

        currentPage = parseInt(link.dataset.page, 10);
        renderPage();
      });

      renderPage();
    });
  </script>
</body>
</html>
