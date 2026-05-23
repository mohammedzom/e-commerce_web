<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="الملف الشخصي — تعديل بياناتك وعرض سجل طلباتك في متجرنا.">
  <title>متجرنا — الملف الشخصي</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-custom sticky-top" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand" href="index.php"><i class="bi bi-bag-heart"></i> متجر<span>نا</span></a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">المنتجات</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">تواصل معنا</a></li>
        </ul>
        <div class="nav-actions">
          <a href="cart.php" class="nav-icon-btn" title="سلة المشتريات"><i class="bi bi-bag"></i><span class="badge-dot"></span></a>
          <a href="profile.php" class="nav-icon-btn" title="حسابي" style="background:var(--color-primary-ultra-light);color:var(--color-primary);"><i class="bi bi-person"></i></a>
          <a href="#" class="btn btn-outline-custom btn-sm-custom" id="logoutBtn">
            <i class="bi bi-box-arrow-right me-1"></i>خروج
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- PAGE HEADER -->
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

  <!-- PROFILE CONTENT -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
          <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-xl);">
            <!-- Profile Header -->
            <div class="text-center mb-4">
              <div class="profile-avatar mx-auto mb-3">م</div>
              <h5 style="font-weight:700;margin-bottom:2px;">محمد أحمد</h5>
              <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عميل منذ يناير 2026</p>
            </div>

            <!-- Nav -->
            <ul class="nav flex-column gap-1" id="profileTabs">
              <li>
                <a href="#" class="nav-link d-flex align-items-center gap-2 active" style="color:var(--color-primary);background:var(--color-primary-ultra-light);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                  <i class="bi bi-person"></i> البيانات الشخصية
                </a>
              </li>
              <li>
                <a href="#" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                  <i class="bi bi-bag"></i> سجل الطلبات
                </a>
              </li>
              <li>
                <a href="#" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                  <i class="bi bi-lock"></i> تغيير كلمة المرور
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
          <!-- Personal Info Form -->
          <div class="card-custom" style="padding:var(--space-2xl);border-radius:var(--radius-xl);margin-bottom:var(--space-xl);">
            <h5 style="font-weight:700;margin-bottom:var(--space-lg);">
              <i class="bi bi-person-gear ms-2 text-primary-custom"></i>
              البيانات الشخصية
            </h5>
            <form id="profileForm">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label-custom" for="profileFirstName">الاسم الأول</label>
                  <input type="text" class="form-control form-control-custom" id="profileFirstName" value="محمد">
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom" for="profileLastName">اسم العائلة</label>
                  <input type="text" class="form-control form-control-custom" id="profileLastName" value="أحمد">
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom" for="profileEmail">البريد الإلكتروني</label>
                  <input type="email" class="form-control form-control-custom" id="profileEmail" value="mohammed@mail.com">
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom" for="profilePhone">رقم الجوال</label>
                  <input type="tel" class="form-control form-control-custom" id="profilePhone" value="0500000000">
                </div>
                <div class="col-12">
                  <label class="form-label-custom" for="profileAddress">العنوان</label>
                  <textarea class="form-control form-control-custom" id="profileAddress" rows="3">الرياض، حي العليا، شارع الملك فهد</textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary-custom" id="saveProfileBtn">
                    <i class="bi bi-check-lg me-2"></i>حفظ التغييرات
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- Order History -->
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
                  <tr>
                    <td><strong>#ORD-1045</strong></td>
                    <td>15 مايو 2026</td>
                    <td>3 منتجات</td>
                    <td>1,375.40 ر.س</td>
                    <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1032</strong></td>
                    <td>8 مايو 2026</td>
                    <td>1 منتج</td>
                    <td>299 ر.س</td>
                    <td><span class="status-badge status-processing"><i class="bi bi-arrow-repeat"></i> قيد التوصيل</span></td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-1018</strong></td>
                    <td>28 أبريل 2026</td>
                    <td>2 منتج</td>
                    <td>548 ر.س</td>
                    <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-0998</strong></td>
                    <td>15 أبريل 2026</td>
                    <td>1 منتج</td>
                    <td>199 ر.س</td>
                    <td><span class="status-badge status-cancelled"><i class="bi bi-x-circle-fill"></i> ملغي</span></td>
                  </tr>
                  <tr>
                    <td><strong>#ORD-0980</strong></td>
                    <td>3 أبريل 2026</td>
                    <td>4 منتجات</td>
                    <td>1,820 ر.س</td>
                    <td><span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> مكتمل</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="footer-brand"><i class="bi bi-bag-heart"></i> متجر<span>نا</span></div>
          <p class="footer-text">متجرنا هو وجهتك الأولى للتسوق الإلكتروني. نوفر لك تجربة تسوق سهلة وممتعة مع أفضل المنتجات وأسرع خدمة شحن.</p>
        </div>
        <div class="col-6 col-lg-2">
          <h6 class="footer-heading">روابط سريعة</h6>
          <ul class="footer-links">
            <li><a href="index.php">الرئيسية</a></li>
            <li><a href="products.php">المنتجات</a></li>
            <li><a href="cart.php">سلة المشتريات</a></li>
            <li><a href="contact.php">تواصل معنا</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-2">
          <h6 class="footer-heading">حسابي</h6>
          <ul class="footer-links">
            <li><a href="login.php">تسجيل الدخول</a></li>
            <li><a href="register.php">إنشاء حساب</a></li>
            <li><a href="profile.php">الملف الشخصي</a></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <h6 class="footer-heading">تواصل معنا</h6>
          <ul class="footer-links">
            <li><i class="bi bi-geo-alt ms-2 text-primary-custom"></i>الرياض، المملكة العربية السعودية</li>
            <li><i class="bi bi-telephone ms-2 text-primary-custom"></i><span dir="ltr">+966 50 000 0000</span></li>
            <li><i class="bi bi-envelope ms-2 text-primary-custom"></i>info@matjarna.com</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom"><p class="mb-0">© 2026 متجرنا. جميع الحقوق محفوظة.</p></div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
