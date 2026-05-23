<?php
$page_title = 'متجرنا — تفاصيل المنتج';
$page_description = 'تفاصيل المنتج — ساعة يد أنيقة بتصميم كلاسيكي. اطلع على المواصفات والسعر وأضف للسلة.';
include 'includes/header.php';
?>

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
      <h1>تفاصيل المنتج</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <a href="products.php">المنتجات</a>
        <span class="separator">/</span>
        <span>ساعة يد أنيقة</span>
      </div>
    </div>
  </div>

  <!-- PRODUCT DETAIL -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
          <div class="product-gallery animate-fadeInUp">
            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop" alt="ساعة يد أنيقة بتصميم كلاسيكي" id="mainProductImage">
          </div>
          <!-- Thumbnails -->
          <div class="d-flex gap-3 mt-3">
            <div class="product-gallery" style="width:80px;height:80px;padding:0.5rem;cursor:pointer;border:2px solid var(--color-primary);aspect-ratio:auto;">
              <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop" alt="صورة 1" style="border-radius:var(--radius-sm);">
            </div>
            <div class="product-gallery" style="width:80px;height:80px;padding:0.5rem;cursor:pointer;border:2px solid var(--color-border-light);aspect-ratio:auto;">
              <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=100&h=100&fit=crop" alt="صورة 2" style="border-radius:var(--radius-sm);">
            </div>
            <div class="product-gallery" style="width:80px;height:80px;padding:0.5rem;cursor:pointer;border:2px solid var(--color-border-light);aspect-ratio:auto;">
              <img src="https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=100&h=100&fit=crop" alt="صورة 3" style="border-radius:var(--radius-sm);">
            </div>
          </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
          <div class="product-info animate-fadeInUp delay-2">
            <div class="product-category-label">إكسسوارات</div>
            <h1>ساعة يد أنيقة بتصميم كلاسيكي</h1>

            <!-- Rating -->
            <div class="d-flex align-items-center gap-2 mb-3">
              <div style="color: var(--color-warning);">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
              </div>
              <span class="text-muted-custom" style="font-size: var(--font-size-sm);">(4.5) — 23 تقييم</span>
            </div>

            <div class="product-detail-price">299 ر.س</div>

            <p class="product-description">
              ساعة يد أنيقة بتصميم كلاسيكي يناسب جميع المناسبات. مصنوعة من مواد عالية الجودة مع حزام جلدي مريح. مقاومة للماء حتى 30 متر. تتميز بعقارب مضيئة وزجاج مقاوم للخدش. ضمان سنتين من الشركة المصنعة.
            </p>

            <!-- Availability -->
            <div class="d-flex align-items-center gap-2 mb-4">
              <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> متوفر في المخزون</span>
            </div>

            <!-- Quantity & Add to Cart -->
            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
              <div class="quantity-control">
                <button class="qty-minus" type="button">−</button>
                <input type="number" value="1" min="1" id="productQuantity">
                <button class="qty-plus" type="button">+</button>
              </div>
              <button class="btn btn-primary-custom px-4" id="addToCartBtn">
                <i class="bi bi-bag-plus me-2"></i>
                إضافة للسلة
              </button>
              <button class="btn btn-outline-custom" id="addToWishlistBtn">
                <i class="bi bi-heart"></i>
              </button>
            </div>

            <!-- Product Meta -->
            <div style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);">
              <div class="d-flex gap-4 flex-wrap" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                <div><strong style="color:var(--color-text);">التصنيف:</strong> إكسسوارات</div>
                <div><strong style="color:var(--color-text);">الكود:</strong> WCH-001</div>
              </div>
            </div>

            <!-- Features -->
            <div style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);margin-top:var(--space-lg);">
              <div class="row g-3">
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-truck text-primary-custom"></i>
                    <span>شحن مجاني</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-arrow-repeat text-primary-custom"></i>
                    <span>استرجاع خلال 14 يوم</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-shield-check text-primary-custom"></i>
                    <span>ضمان سنتين</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-credit-card text-primary-custom"></i>
                    <span>دفع آمن</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Products -->
      <div class="mt-5 pt-4" style="border-top:1px solid var(--color-border-light);">
        <div class="section-header">
          <h2 class="section-title" style="font-size:var(--font-size-xl);">منتجات ذات صلة</h2>
        </div>
        <div class="row g-4">
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <div class="product-actions">
                  <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
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
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <div class="product-actions">
                  <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
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
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <div class="product-actions">
                  <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                </div>
                <img src="https://images.unsplash.com/photo-1594534475808-b18fc33b045e?w=400&h=400&fit=crop" alt="سوار ذهبي">
              </div>
              <div class="card-body">
                <div class="product-category">إكسسوارات</div>
                <h6 class="product-title"><a href="product-detail.php">سوار ذهبي أنيق</a></h6>
                <div class="product-price">175 ر.س</div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <span class="product-badge badge-sale">خصم</span>
                <div class="product-actions">
                  <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
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
        </div>
      </div>
    </div>
  </section>
  <?php include 'includes/footer.php'; ?>