<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="تصفح جميع المنتجات المتوفرة في متجرنا مع إمكانية التصفية حسب التصنيف والسعر.">
  <title>متجرنا — المنتجات</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-custom sticky-top" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <i class="bi bi-bag-heart"></i> متجر<span>نا</span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link active" href="products.php">المنتجات</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">تواصل معنا</a></li>
        </ul>
        <div class="nav-actions">
          <a href="cart.php" class="nav-icon-btn" title="سلة المشتريات">
            <i class="bi bi-bag"></i><span class="badge-dot"></span>
          </a>
          <a href="profile.php" class="nav-icon-btn" title="حسابي"><i class="bi bi-person"></i></a>
          <a href="login.php" class="btn btn-primary-custom btn-sm-custom">تسجيل الدخول</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="container">
      <h1>المنتجات</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <span>المنتجات</span>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-4">

        <!-- Filters Sidebar -->
        <div class="col-lg-3">
          <!-- Search -->
          <div class="filter-card">
            <h6><i class="bi bi-search ms-2"></i>بحث</h6>
            <input type="text" class="form-control form-control-custom" placeholder="ابحث عن منتج ..." id="productSearch">
          </div>

          <!-- Categories -->
          <div class="filter-card">
            <h6><i class="bi bi-grid ms-2"></i>التصنيفات</h6>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catAll" checked>
              <label class="form-check-label" for="catAll">الكل</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catElectronics">
              <label class="form-check-label" for="catElectronics">إلكترونيات</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catAccessories">
              <label class="form-check-label" for="catAccessories">إكسسوارات</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catShoes">
              <label class="form-check-label" for="catShoes">أحذية</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catBags">
              <label class="form-check-label" for="catBags">حقائب</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="catPerfumes">
              <label class="form-check-label" for="catPerfumes">عطور</label>
            </div>
          </div>

          <!-- Price Range -->
          <div class="filter-card">
            <h6><i class="bi bi-currency-dollar ms-2"></i>نطاق السعر</h6>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" id="priceAll" checked>
              <label class="form-check-label" for="priceAll">الكل</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" id="price1">
              <label class="form-check-label" for="price1">أقل من 100 ر.س</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" id="price2">
              <label class="form-check-label" for="price2">100 - 300 ر.س</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" id="price3">
              <label class="form-check-label" for="price3">300 - 500 ر.س</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="priceRange" id="price4">
              <label class="form-check-label" for="price4">أكثر من 500 ر.س</label>
            </div>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
          <!-- Toolbar -->
          <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <p class="mb-0 text-muted-custom" style="font-size: var(--font-size-sm);">
              عرض <strong>12</strong> منتج
            </p>
            <div class="d-flex align-items-center gap-2">
              <label class="form-label-custom mb-0" style="white-space:nowrap;">ترتيب حسب:</label>
              <select class="form-select form-select-custom" id="sortProducts" style="width:auto;min-width:160px;">
                <option>الأحدث</option>
                <option>السعر: الأقل للأعلى</option>
                <option>السعر: الأعلى للأقل</option>
                <option>الأكثر مبيعاً</option>
              </select>
            </div>
          </div>

          <div class="row g-4">
            <!-- Product 1 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-new">جديد</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop" alt="ساعة يد أنيقة">
                </div>
                <div class="card-body">
                  <div class="product-category">إكسسوارات</div>
                  <h6 class="product-title"><a href="product-detail.php">ساعة يد أنيقة بتصميم كلاسيكي</a></h6>
                  <div class="product-price">299 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 2 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-sale">خصم</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop" alt="سماعات لاسلكية">
                </div>
                <div class="card-body">
                  <div class="product-category">إلكترونيات</div>
                  <h6 class="product-title"><a href="product-detail.php">سماعات لاسلكية عالية الجودة</a></h6>
                  <div class="product-price"><span class="old-price">450 ر.س</span> 349 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 3 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400&h=400&fit=crop" alt="حذاء رياضي">
                </div>
                <div class="card-body">
                  <div class="product-category">أحذية</div>
                  <h6 class="product-title"><a href="product-detail.php">حذاء رياضي مريح وعصري</a></h6>
                  <div class="product-price">199 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 4 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-new">جديد</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=400&h=400&fit=crop" alt="كاميرا بولارويد">
                </div>
                <div class="card-body">
                  <div class="product-category">إلكترونيات</div>
                  <h6 class="product-title"><a href="product-detail.php">كاميرا بولارويد بتصميم ريترو</a></h6>
                  <div class="product-price">549 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 5 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop" alt="نظارة شمسية">
                </div>
                <div class="card-body">
                  <div class="product-category">إكسسوارات</div>
                  <h6 class="product-title"><a href="product-detail.php">نظارة شمسية بإطار أنيق</a></h6>
                  <div class="product-price">129 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 6 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-sale">خصم</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=400&h=400&fit=crop" alt="عطر فاخر">
                </div>
                <div class="card-body">
                  <div class="product-category">عطور</div>
                  <h6 class="product-title"><a href="product-detail.php">عطر فاخر بتركيبة فرنسية</a></h6>
                  <div class="product-price"><span class="old-price">380 ر.س</span> 280 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 7 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=400&h=400&fit=crop" alt="حقيبة جلدية">
                </div>
                <div class="card-body">
                  <div class="product-category">حقائب</div>
                  <h6 class="product-title"><a href="product-detail.php">حقيبة جلدية فاخرة</a></h6>
                  <div class="product-price">420 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 8 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1546868871-af0de0ae72be?w=400&h=400&fit=crop" alt="ساعة ذكية">
                </div>
                <div class="card-body">
                  <div class="product-category">إلكترونيات</div>
                  <h6 class="product-title"><a href="product-detail.php">ساعة ذكية متعددة الاستخدامات</a></h6>
                  <div class="product-price">699 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 9 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop" alt="حقيبة ظهر">
                </div>
                <div class="card-body">
                  <div class="product-category">حقائب</div>
                  <h6 class="product-title"><a href="product-detail.php">حقيبة ظهر عملية للسفر</a></h6>
                  <div class="product-price">189 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 10 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-sale">خصم</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop" alt="حذاء رياضي أحمر">
                </div>
                <div class="card-body">
                  <div class="product-category">أحذية</div>
                  <h6 class="product-title"><a href="product-detail.php">حذاء رياضي بتصميم جريء</a></h6>
                  <div class="product-price"><span class="old-price">320 ر.س</span> 249 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 11 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1594534475808-b18fc33b045e?w=400&h=400&fit=crop" alt="سوار ذهبي">
                </div>
                <div class="card-body">
                  <div class="product-category">إكسسوارات</div>
                  <h6 class="product-title"><a href="product-detail.php">سوار ذهبي أنيق للنساء</a></h6>
                  <div class="product-price">175 ر.س</div>
                </div>
              </div>
            </div>
            <!-- Product 12 -->
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <span class="product-badge badge-new">جديد</span>
                  <div class="product-actions">
                    <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                    <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                  </div>
                  <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=400&fit=crop" alt="سماعة رأس">
                </div>
                <div class="card-body">
                  <div class="product-category">إلكترونيات</div>
                  <h6 class="product-title"><a href="product-detail.php">سماعة رأس احترافية</a></h6>
                  <div class="product-price">599 ر.س</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <nav class="mt-5 d-flex justify-content-center" id="productsPagination">
            <ul class="pagination" style="gap:4px;">
              <li class="page-item disabled">
                <a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-muted);">
                  <i class="bi bi-chevron-right"></i>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link border-0 rounded-3" href="#" style="background:var(--color-primary);border-color:var(--color-primary);">1</a>
              </li>
              <li class="page-item">
                <a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">2</a>
              </li>
              <li class="page-item">
                <a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">3</a>
              </li>
              <li class="page-item">
                <a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">
                  <i class="bi bi-chevron-left"></i>
                </a>
              </li>
            </ul>
          </nav>
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
      <div class="footer-bottom">
        <p class="mb-0">© 2026 متجرنا. جميع الحقوق محفوظة.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
