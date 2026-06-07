<?php
$page_title = 'المنتجات';
$page_description = 'تصفح جميع المنتجات المتوفرة في متجرنا مع إمكانية التصفية حسب التصنيف والسعر.';
require 'config/config.php';
include 'includes/header.php';

$count_prodects_in_one_page = 9;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$count_stmt = $conn->query("SELECT COUNT(*) FROM products");
$total_products = (int)$count_stmt->fetchColumn();
$total_pages = max(1, (int)ceil($total_products / $count_prodects_in_one_page));

if ($current_page > $total_pages) {
    $current_page = $total_pages;
}

$offset = ($current_page - 1) * $count_prodects_in_one_page;


if(isset($_GET['search'])) {
  $query = "SELECT * FROM products WHERE name LIKE :search OR description LIKE :search ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
  $stmt = $conn->prepare($query);
  $stmt->bindValue(':search', '%' . $_GET['search'] . '%');
} else {
  $query = "SELECT * FROM products ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
  $stmt = $conn->prepare($query);
}

$stmt->bindValue(':limit', $count_prodects_in_one_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<?php

if (isset($_POST['add-to-cart'])) {
  $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
  if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('قم بتسجيل الدخول أولاً');</script>";
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
        <?php foreach ($products as $product) { ?>
          <div class="col-6 col-md-4">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <img src="<?php echo $product->image_url ?>" alt="<?php echo $product->name ?>">
              </div>
              <div class="card-body">
                <div class="product-category"><?php echo $catory_list[$product->category_id] ?></div>
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
        <?php }; ?>
      </div>

      <?php if ($total_pages > 1): ?>
      <nav class="mt-5 d-flex justify-content-center" id="productsPagination">
        <ul class="pagination" style="gap:4px;">
          <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link border-0 rounded-3" href="<?php echo ($current_page > 1) ? '?page=' . ($current_page - 1) : '#'; ?>" style="color:var(--color-text-muted);">
              <i class="bi bi-chevron-right"></i>
            </a>
          </li>

          <?php
          $max_visible = 5;
          $start_page = max(1, $current_page - floor($max_visible / 2));
          $end_page = min($total_pages, $start_page + $max_visible - 1);
          $start_page = max(1, $end_page - $max_visible + 1);

          if ($start_page > 1): ?>
            <li class="page-item">
              <a class="page-link border-0 rounded-3" href="?page=1" style="color:var(--color-text-secondary);">1</a>
            </li>
            <?php if ($start_page > 2): ?>
              <li class="page-item disabled">
                <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">…</span>
              </li>
            <?php endif; ?>
          <?php endif; ?>

          <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
            <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
              <a class="page-link border-0 rounded-3" href="?page=<?php echo $i; ?>"
                 style="<?php echo ($i === $current_page) ? 'background:var(--color-primary);border-color:var(--color-primary);' : 'color:var(--color-text-secondary);'; ?>">
                <?php echo $i; ?>
              </a>
            </li>
          <?php endfor; ?>

          <?php 
          if ($end_page < $total_pages): ?>
            <?php if ($end_page < $total_pages - 1): ?>
              <li class="page-item disabled">
                <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">…</span>
              </li>
            <?php endif; ?>
            <li class="page-item">
              <a class="page-link border-0 rounded-3" href="?page=<?php echo $total_pages; ?>" style="color:var(--color-text-secondary);"><?php echo $total_pages; ?></a>
            </li>
          <?php endif; ?>

          <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
            <a class="page-link border-0 rounded-3" href="<?php echo ($current_page < $total_pages) ? '?page=' . ($current_page + 1) : '#'; ?>" style="color:var(--color-text-secondary);">
              <i class="bi bi-chevron-left"></i>
            </a>
          </li>
        </ul>
      </nav>
      <?php endif; ?>
    </div>
  </section>
  <?php include 'includes/footer.php'; ?>