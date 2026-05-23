<!DOCTYPE html>
<html lang="ar" dir="rtl">

<?php
$page_title = 'الصفحة الرئيسية';
$page_description = 'متجرنا — تسوّق أفضل المنتجات بجودة عالية وأسعار مناسبة. شحن سريع وخدمة عملاء متميزة.';
include 'includes/header.php'; ?>

<body>

  <?php include 'includes/navbar.php'; ?>

  <section class="hero-section" id="hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <!-- Text Content -->
        <div class="col-lg-6">
          <div class="hero-content animate-fadeInUp">
            <h1>
              اكتشف تجربة تسوّق<br>
              <span class="highlight">فريدة ومميزة</span>
            </h1>
            <p>
              نقدم لك أفضل المنتجات بجودة عالية وأسعار مناسبة، مع خدمة شحن سريعة وضمان استرجاع كامل.
            </p>
            <!-- Search Bar -->
            <div class="hero-search">
              <input type="text" placeholder="ابحث عن منتج ..." id="heroSearchInput">
              <button class="search-btn" id="heroSearchBtn">
                <i class="bi bi-search"></i>
              </button>
            </div>
            <div class="d-flex gap-4 mt-4">
              <div>
                <div style="font-size:1.5rem;font-weight:700;color:var(--color-text);">+500</div>
                <div style="font-size:0.8rem;color:var(--color-text-muted);">منتج متوفر</div>
              </div>
              <div>
                <div style="font-size:1.5rem;font-weight:700;color:var(--color-text);">+2,000</div>
                <div style="font-size:0.8rem;color:var(--color-text-muted);">عميل سعيد</div>
              </div>
              <div>
                <div style="font-size:1.5rem;font-weight:700;color:var(--color-text);">24/7</div>
                <div style="font-size:0.8rem;color:var(--color-text-muted);">دعم فني</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <div class="hero-image animate-fadeInUp delay-2">
            <img src="assets/images/hero.jpeg" alt="تسوق أونلاين">
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       FEATURES SECTION
       ============================================ -->
  <section class="section-padding" style="background-color: var(--color-white);" id="features">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-6 col-lg-3 reveal">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-truck"></i>
            </div>
            <h5>شحن مجاني</h5>
            <p>شحن مجاني لجميع الطلبات فوق 200 ش</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <h5>ضمان الجودة</h5>
            <p>جميع منتجاتنا أصلية ومضمونة 100%</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-arrow-repeat"></i>
            </div>
            <h5>استرجاع سهل</h5>
            <p>إمكانية الاسترجاع خلال 14 يوم</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 reveal">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-headset"></i>
            </div>
            <h5>دعم متواصل</h5>
            <p>فريق دعم متاح على مدار الساعة</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================
       FEATURED PRODUCTS
       ============================================ -->
  <section class="section-padding" id="featured-products">
    <div class="container">
      <div class="section-header reveal">
        <h2 class="section-title">منتجات مميزة</h2>
        <p class="section-subtitle">اختيارات مميزة من أفضل المنتجات لدينا</p>
      </div>

      <div class="row g-4">
        <!-- Product 1 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                299 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                <span class="old-price">450 ش</span>
                349 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                199 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
          <div class="card-custom product-card">
            <div class="product-img-wrapper">
              <span class="product-badge badge-new">جديد</span>
              <div class="product-actions">
                <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
              </div>
              <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=400&h=400&fit=crop" alt="كاميرا احترافية">
            </div>
            <div class="card-body">
              <div class="product-category">إلكترونيات</div>
              <h6 class="product-title"><a href="product-detail.php">كاميرا بولارويد بتصميم ريترو</a></h6>
              <div class="product-price">
                549 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                129 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                <span class="old-price">380 ش</span>
                280 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                420 ش
              </div>
            </div>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="col-6 col-md-4 col-lg-3 reveal">
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
              <div class="product-price">
                699 ش
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- View All -->
      <div class="text-center mt-5 reveal">
        <a href="products.php" class="btn btn-outline-custom px-4">
          عرض جميع المنتجات
          <i class="bi bi-arrow-left me-1"></i>
        </a>
      </div>
    </div>
  </section>


  <!-- ============================================
       CTA SECTION
       ============================================ -->
  <section class="section-padding" style="background-color: var(--color-white);" id="cta">
    <div class="container">
      <div class="text-center reveal" style="max-width: 560px; margin: 0 auto;">
        <div class="feature-icon mx-auto mb-4">
          <i class="bi bi-envelope-heart"></i>
        </div>
        <h2 class="section-title" style="font-size: var(--font-size-xl);">انضم لقائمتنا البريدية</h2>
        <p class="text-muted-custom mb-4" style="font-size: var(--font-size-sm);">
          اشترك ليصلك كل جديد من العروض والخصومات الحصرية
        </p>
        <div class="hero-search mx-auto" style="max-width: 400px;">
          <input type="email" placeholder="بريدك الإلكتروني" id="newsletterEmail">
          <button class="search-btn" id="newsletterBtn">
            <i class="bi bi-send"></i>
          </button>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>