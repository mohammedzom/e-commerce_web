<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="سلة المشتريات — راجع منتجاتك وأكمل عملية الشراء بسهولة.">
  <title>متجرنا — سلة المشتريات</title>
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
          <a href="profile.php" class="nav-icon-btn" title="حسابي"><i class="bi bi-person"></i></a>
          <a href="login.php" class="btn btn-primary-custom btn-sm-custom">تسجيل الدخول</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="container">
      <h1>سلة المشتريات</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <span>سلة المشتريات</span>
      </div>
    </div>
  </div>

  <!-- CART CONTENT -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-4">
        <!-- Cart Table -->
        <div class="col-lg-8">
          <div class="table-responsive table-custom">
            <table class="table mb-0" id="cartTable">
              <thead>
                <tr>
                  <th style="width:50%;">المنتج</th>
                  <th>السعر</th>
                  <th>الكمية</th>
                  <th>الإجمالي</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <!-- Item 1 -->
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div style="width:64px;height:64px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop" alt="ساعة يد" style="width:100%;height:100%;object-fit:cover;">
                      </div>
                      <div>
                        <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:2px;">ساعة يد أنيقة بتصميم كلاسيكي</h6>
                        <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">إكسسوارات</span>
                      </div>
                    </div>
                  </td>
                  <td style="white-space:nowrap;">299 ر.س</td>
                  <td>
                    <div class="quantity-control">
                      <button class="qty-minus" type="button">−</button>
                      <input type="number" value="1" min="1">
                      <button class="qty-plus" type="button">+</button>
                    </div>
                  </td>
                  <td style="white-space:nowrap;font-weight:600;">299 ر.س</td>
                  <td>
                    <button class="btn btn-danger-soft btn-remove-item" title="حذف">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </td>
                </tr>
                <!-- Item 2 -->
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div style="width:64px;height:64px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&h=100&fit=crop" alt="سماعات" style="width:100%;height:100%;object-fit:cover;">
                      </div>
                      <div>
                        <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:2px;">سماعات لاسلكية عالية الجودة</h6>
                        <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">إلكترونيات</span>
                      </div>
                    </div>
                  </td>
                  <td style="white-space:nowrap;">349 ر.س</td>
                  <td>
                    <div class="quantity-control">
                      <button class="qty-minus" type="button">−</button>
                      <input type="number" value="2" min="1">
                      <button class="qty-plus" type="button">+</button>
                    </div>
                  </td>
                  <td style="white-space:nowrap;font-weight:600;">698 ر.س</td>
                  <td>
                    <button class="btn btn-danger-soft btn-remove-item" title="حذف">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </td>
                </tr>
                <!-- Item 3 -->
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div style="width:64px;height:64px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                        <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=100&h=100&fit=crop" alt="حذاء" style="width:100%;height:100%;object-fit:cover;">
                      </div>
                      <div>
                        <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:2px;">حذاء رياضي مريح وعصري</h6>
                        <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);">أحذية</span>
                      </div>
                    </div>
                  </td>
                  <td style="white-space:nowrap;">199 ر.س</td>
                  <td>
                    <div class="quantity-control">
                      <button class="qty-minus" type="button">−</button>
                      <input type="number" value="1" min="1">
                      <button class="qty-plus" type="button">+</button>
                    </div>
                  </td>
                  <td style="white-space:nowrap;font-weight:600;">199 ر.س</td>
                  <td>
                    <button class="btn btn-danger-soft btn-remove-item" title="حذف">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Continue Shopping -->
          <div class="mt-3">
            <a href="products.php" class="btn btn-outline-custom">
              <i class="bi bi-arrow-right me-2"></i>
              متابعة التسوق
            </a>
          </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
          <div class="cart-summary" id="cartSummary">
            <h5><i class="bi bi-receipt ms-2"></i>ملخص الطلب</h5>
            <div class="cart-summary-row">
              <span>المجموع الفرعي</span>
              <span>1,196 ر.س</span>
            </div>
            <div class="cart-summary-row">
              <span>الشحن</span>
              <span style="color:var(--color-success);">مجاني</span>
            </div>
            <div class="cart-summary-row">
              <span>الضريبة (15%)</span>
              <span>179.40 ر.س</span>
            </div>
            <div class="cart-summary-row total">
              <span>الإجمالي</span>
              <span style="color:var(--color-primary);">1,375.40 ر.س</span>
            </div>

            <!-- Coupon -->
            <div class="mt-4">
              <label class="form-label-custom">كود الخصم</label>
              <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-custom" placeholder="أدخل كود الخصم" id="couponInput">
                <button class="btn btn-outline-custom" style="white-space:nowrap;" id="applyCouponBtn">تطبيق</button>
              </div>
            </div>

            <button class="btn btn-primary-custom w-100 mt-4" id="checkoutBtn">
              <i class="bi bi-lock me-2"></i>
              إتمام الطلب
            </button>
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
