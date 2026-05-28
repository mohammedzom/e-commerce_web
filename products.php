<?php
$page_title = 'المنتجات';
$page_description = 'تصفح جميع المنتجات المتوفرة في متجرنا مع إمكانية التصفية حسب التصنيف والسعر.';
require 'config/config.php';
include 'includes/header.php';
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $products->fetchAll(PDO::FETCH_OBJ);
?>
<?php

function addToCart(int $product_id): void
{
  if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('قم بتسجيل الدخول أولاً');</script>";
    return;
  }
  // $cart_id = $_SESSION['cart_id'];
  // $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
  // $stmt->execute([
  //   'cart_id' => $cart_id,
  //   'product_id' => $product_id,
  //   'quantity' => 1
  // ]);
  echo "<script>alert('تمت الإضافة إلى السلة');</script>";
}

?>

<body>

  <?php include 'includes/navbar.php'; ?>

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

  <section class="section-padding">
    <div class="container">

      <div class="row g-4">
        <!-- Product 1 -->
        <?php foreach ($products as $product) { ?>
          <div class="col-6 col-md-4">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <span class="product-badge badge-new">جديد</span>
                <img src="<?php echo $product->image_url ?>" alt="<?php echo $product->name ?>">
              </div>
              <div class="card-body">
                <div class="product-category"><?php echo $product->category ?></div>
                <h6 class="product-title"><a href="product.php?id=<?php echo $product->id ?>"><?php echo $product->name ?></a></h6>
                <ul style="display: flex; justify-content: space-between; align-items: center;">
                  <li>
                    <div class="product-price"><?php echo $product->price ?> ش</div>
                  </li>
                  <li>
                    <button class="btn btn-primary btn-sm" onclick="addToCart(<?php echo $product->id ?>)" title="أضف للسلة" style="padding: 6px 12px;"> <i class="bi bi-cart"></i> إضافة للسلة </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        <?php }; ?>
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
  </section>
  <?php include 'includes/footer.php'; ?>