<!DOCTYPE html>
<html lang="ar" dir="rtl">

<?php
$page_title = 'الصفحة الرئيسية';
$page_description = 'متجرنا — تسوّق أفضل المنتجات بجودة عالية وأسعار مناسبة. شحن سريع وخدمة عملاء متميزة.';
require 'config/config.php';
include 'includes/header.php';

$products = $conn->query("SELECT * FROM products WHERE stock_quantity > 0 LIMIT 4");
$products = $products->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['subscribe'])) {
  $email = $_POST['email'];

  if (empty($email)) {
    echo "<script>alert('البريد الإلكتروني مطلوب')</script>";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('البريد الإلكتروني غير صالح')</script>";
  } else {
    $checkEmail = $conn->prepare("SELECT email FROM newsletter_subscribers WHERE email = :email");
    $checkEmail->execute(['email' => $email]);
    if ($checkEmail->rowCount() > 0) {
      echo "<script>alert('البريد الإلكتروني موجود بالفعل!')</script>";
    } else {
      $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
      $stmt->execute(['email' => $email]);
      echo "<script>alert('تم الاشتراك بنجاح!')</script>";
    }
  }
}

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  header("Location: products.php?search=$search");
}
?>

<body>

  <?php include 'includes/navbar.php'; ?>

  <section class="hero-section" id="hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-content animate-fadeInUp">
            <h1>
              اكتشف تجربة تسوّق<br>
              <span class="highlight">فريدة ومميزة</span>
            </h1>
            <p>
              نقدم لك أفضل المنتجات بجودة عالية وأسعار مناسبة، مع خدمة شحن سريعة وضمان استرجاع كامل.
            </p>
            <div class="hero-search">
              <form action="products.php" method="GET" class="d-flex">
                <input type="text" name="search" placeholder="ابحث عن منتج ..." id="heroSearchInput">
                <button type="submit" class="search-btn" id="heroSearchBtn">
                  <i class="bi bi-search"></i>
                </button>
              </form>
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

  <section class="section-padding" id="featured-products">
    <div class="container">
      <div class="section-header reveal">
        <h2 class="section-title">منتجات مميزة</h2>
        <p class="section-subtitle">اختيارات مميزة من أفضل المنتجات لدينا</p>
      </div>

      <div class="row g-4">

        <?php
        foreach ($products as $product) {
        ?>
          <div class="col-6 col-md-4 col-lg-3 reveal">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <div class="product-actions">
                  <button class="product-action-btn" title="أضف للمفضلة"><i class="bi bi-heart"></i></button>
                  <button class="product-action-btn" title="عرض سريع"><i class="bi bi-eye"></i></button>
                </div>
                <img src="<?php echo $product->image_url ?>" alt="<?php echo $product->name ?>">
              </div>
              <div class="card-body">
                <div class="product-category"><?php echo $product->category ?></div>
                <h6 class="product-title"><a href="product-detail.php?id=<?php echo $product->product_id ?>"><?php echo $product->name ?></a></h6>
                <div class="product-price">
                  <?php echo $product->price ?> ش
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="text-center mt-5 reveal">
          <a href="products.php" class="btn btn-outline-custom px-4">
            عرض جميع المنتجات
            <i class="bi bi-arrow-left me-1"></i>
          </a>
        </div>
      </div>
  </section>


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
          <form action="" method="POST">
            <input type="email" placeholder="بريدك الإلكتروني" id="newsletterEmail" name="email" required>
            <button type="submit" name="subscribe" class="search-btn" id="newsletterBtn">
              <i class="bi bi-send"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>