<?php
$page_title = 'الصفحة الرئيسية';
$page_description = 'متجرنا — تسوّق أفضل المنتجات بجودة عالية وأسعار مناسبة. شحن سريع وخدمة عملاء متميزة.';
require 'config/config.php';
include 'includes/header.php';

$products = $conn->query("SELECT * FROM products WHERE stock_quantity > 0 LIMIT 6");
$products = $products->fetchAll(PDO::FETCH_OBJ);




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
                <h6 class="product-title"><a href="product_detail.php?id=<?php echo $product->product_id ?>"><?php echo $product->name ?></a></h6>
                <ul style="display: flex; justify-content: space-between; align-items: center;">
                  <li>
                    <div class="product-price"><?php echo $product->price ?> ش</div>
                  </li>
                  <li>
                    <form method="POST" action="<?php echo APPURL; ?>actions/add_to_cart.php">
                      <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                      <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm" title="أضف للسلة" style="padding: 6px 12px;">
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

  <?php include 'includes/footer.php'; ?>