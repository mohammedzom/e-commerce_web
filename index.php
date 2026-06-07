<!DOCTYPE html>
<html lang="ar" dir="rtl">

<?php
$page_title = 'الصفحة الرئيسية';
$page_description = 'متجرنا — تسوّق أفضل المنتجات بجودة عالية وأسعار مناسبة. شحن سريع وخدمة عملاء متميزة.';
require 'config/config.php';
include 'includes/header.php';

$products = $conn->query("SELECT * FROM products WHERE stock_quantity > 0 LIMIT 4");
$products = $products->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['add-to-cart'])) {
  $product_id = $_POST['product_id'];
  $user_id = $_SESSION['user_id'];
  if (!$user_id) {
    echo '<script>alert("يجب تسجيل الدخول أولاً"); window.location.href = "auth/login.php";</script>';
    exit;
  }
  $product = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
  $product->execute(['id' => $product_id]);
  $product = $product->fetch(PDO::FETCH_OBJ);
  if ($product->stock_quantity <= 0) {
    echo "<script>alert('المنتج غير متوفر حالياً');</script>";
    exit;
  }
  $cart_item = $conn->prepare("SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
  $cart_item->execute(['user_id' => $_SESSION['user_id'], 'product_id' => $product_id]);
  $cart_item = $cart_item->fetch(PDO::FETCH_OBJ);
  if ($cart_item) {
    echo "<script>alert('المنتج موجود بالفعل في السلة'); window.location.href = 'cart.php';</script>";
    exit;
  } else {
    $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)")
    ->execute(['user_id' => $_SESSION['user_id'], 'product_id' => $product_id, 'quantity' => 1]);

    echo "<script>alert('تمت الإضافة إلى السلة'); window.location.href = 'cart.php';</script>";
    exit;
  }
}


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

$categories = $conn->prepare("SELECT * FROM categories");
$categories->execute();
$categories = $categories->fetchAll(PDO::FETCH_OBJ);
$catory_list = [];
foreach ($categories as $category) {
  $catory_list[$category->category_id] = $category->name;
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

  <section class="section-padding" id="featured-products">
    <div class="container">
      <div class="section-header reveal">
        <h2 class="section-title">منتجات مميزة</h2>
        <p class="section-subtitle">اختيارات مميزة من أفضل المنتجات لدينا</p>
      </div>

      <div class="row g-4">

        <?php
        foreach ($products as $product) :
        ?>
          
            <div class="col-6 col-md-4">
              <div class="card-custom product-card">
                <div class="product-img-wrapper">
                  <img src="<?php echo $product->image_url ?>" alt="<?php echo $product->name ?>">
                </div>
              <div class="card-body">
                <div class="product-category"><?php echo isset($catory_list[$product->category_id]) ? htmlspecialchars($catory_list[$product->category_id]) : 'غير مصنف' ?></div>
                <h6 class="product-title"><a href="product-detail.php?id=<?php echo $product->product_id ?>"><?php echo $product->name ?></a></h6>
                <ul style="display: flex; justify-content: space-between; align-items: center;">
                  <li>
                    <div class="product-price"><?php echo $product->price ?> ش</div>
                  </li>
                  <li>
                    <form method="POST">
                      <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                      <button type="submit" name="add-to-cart" class="btn btn-primary btn-sm" title="أضف للسلة" style="padding: 6px 12px;"> 
                        <i class="bi bi-cart"></i> إضافة للسلة 
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php
        endforeach;
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