<?php
$page_title = 'المنتجات';
$page_description = 'تصفح جميع المنتجات المتوفرة في متجرنا مع إمكانية التصفية حسب التصنيف والسعر.';
require 'config/config.php';
include 'includes/header.php';

$count_prodects_in_one_page = 9;

// Capture filters
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$where_clauses = [];
$params = [];

if ($search !== '') {
  $where_clauses[] = "(name LIKE :search OR description LIKE :search)";
  $params[':search'] = '%' . $search . '%';
}

if ($category_id > 0) {
  $where_clauses[] = "category_id = :category_id";
  $params[':category_id'] = $category_id;
}

$where_sql = '';
if (count($where_clauses) > 0) {
  $where_sql = "WHERE " . implode(' AND ', $where_clauses);
}

// Get total count based on filters
$count_query = "SELECT COUNT(*) FROM products $where_sql";
$count_stmt = $conn->prepare($count_query);
foreach ($params as $key => $val) {
  $count_stmt->bindValue($key, $val);
}
$count_stmt->execute();
$total_products = (int)$count_stmt->fetchColumn();

$total_pages = max(1, (int)ceil($total_products / $count_prodects_in_one_page));
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
if ($current_page > $total_pages) {
  $current_page = $total_pages;
}
$offset = ($current_page - 1) * $count_prodects_in_one_page;

$order_by = "ORDER BY created_at DESC";
if ($sort == 'price-low-high') {
  $order_by = "ORDER BY price ASC";
} elseif ($sort == 'price-high-low') {
  $order_by = "ORDER BY price DESC";
}

$query = "SELECT * FROM products $where_sql $order_by LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);

foreach ($params as $key => $val) {
  $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit', $count_prodects_in_one_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<?php




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

  <!-- MAIN CONTENT -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-3">
          <div class="filter-card filter-card-search">
            <h6><i class="bi bi-search ms-2"></i>بحث</h6>
            <form method="GET" action="products.php">
              <?php if (isset($_GET['sort'])): ?>
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($_GET['sort']); ?>">
              <?php endif; ?>
              <?php if ($category_id > 0): ?>
                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
              <?php endif; ?>

              <div class="input-group mb-3 mt-3">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control form-control-custom" placeholder="ابحث عن منتج...">
                <button class="btn btn-primary px-3" type="submit" style="z-index: 1;"><i class="bi bi-search"></i></button>
              </div>

              <?php if ($search !== ''): ?>
                <a href="products.php?<?php echo http_build_query(array_diff_key($_GET, ['search' => ''])); ?>" class="btn btn-outline-danger w-100 py-2 d-flex justify-content-center align-items-center">
                  <i class="bi bi-x-circle ms-2"></i> مسح البحث
                </a>
              <?php endif; ?>
            </form>
          </div>

          <div class="filter-card">
            <h6><i class="bi bi-grid ms-2"></i>التصنيفات</h6>
            <div class="d-flex flex-wrap gap-2 mt-3">
              <?php
              $cat_get = $_GET;
              unset($cat_get['page']);
              ?>

              <?php unset($cat_get['category']); ?>
              <a href="products.php?<?php echo http_build_query($cat_get); ?>" class="btn <?php echo $category_id == 0 ? 'btn-primary' : 'btn-outline-secondary'; ?> btn-sm rounded-pill px-3 transition-base">
                الكل
              </a>

              <?php foreach ($categories as $category): ?>
                <?php $cat_get['category'] = $category->category_id; ?>
                <a href="products.php?<?php echo http_build_query($cat_get); ?>" class="btn <?php echo $category_id == $category->category_id ? 'btn-primary' : 'btn-outline-secondary'; ?> btn-sm rounded-pill px-3 transition-base">
                  <?php echo htmlspecialchars($category->name); ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <p class="mb-0 text-muted-custom" style="font-size: var(--font-size-sm);">
              عرض <strong><?php echo count($products); ?></strong> من أصل <strong><?php echo $total_products; ?></strong> منتج
            </p>
            <div class="d-flex align-items-center gap-2">
              <label class="form-label-custom mb-0" style="white-space:nowrap;">ترتيب حسب:</label>
              <form method="GET" action="products.php">
                <?php if ($search !== ''): ?>
                  <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <?php endif; ?>
                <?php if ($category_id > 0): ?>
                  <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                <?php endif; ?>
                <select class="form-select form-select-custom" id="sortProducts" name="sort" style="width:auto;min-width:160px;" onchange="this.form.submit()">
                  <?php
                  $sort_options = [
                    'newest' => 'الأحدث',
                    'price-low-high' => 'السعر: الأقل للأعلى',
                    'price-high-low' => 'السعر: الأعلى للأقل'
                  ];
                  foreach ($sort_options as $key => $value) {
                    echo '<option value="' . $key . '" ' . ($sort == $key ? 'selected' : '') . '>' . $value . '</option>';
                  }
                  ?>
                </select>
              </form>
            </div>
          </div>

          <div class="row g-4">
            <?php foreach ($products as $product) : ?>
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
            <?php endforeach; ?>
          </div>

          <?php if ($total_pages > 1): ?>
            <nav class="mt-5 d-flex justify-content-center" id="productsPagination">
              <?php
              $page_get = $_GET;
              unset($page_get['page']);
              $base_q = http_build_query($page_get);
              $base_url = 'products.php?' . ($base_q ? $base_q . '&' : '');
              ?>
              <ul class="pagination" style="gap:4px;">
                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                  <a class="page-link border-0 rounded-3" href="<?php echo ($current_page > 1) ? $base_url . 'page=' . ($current_page - 1) : '#'; ?>" style="color:var(--color-text-muted);">
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
                    <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=1" style="color:var(--color-text-secondary);">1</a>
                  </li>
                  <?php if ($start_page > 2): ?>
                    <li class="page-item disabled">
                      <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">…</span>
                    </li>
                  <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                  <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                    <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $i; ?>"
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
                    <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $total_pages; ?>" style="color:var(--color-text-secondary);"><?php echo $total_pages; ?></a>
                  </li>
                <?php endif; ?>

                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                  <a class="page-link border-0 rounded-3" href="<?php echo ($current_page < $total_pages) ? $base_url . 'page=' . ($current_page + 1) : '#'; ?>" style="color:var(--color-text-secondary);">
                    <i class="bi bi-chevron-left"></i>
                  </a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
  </section>
  <?php include 'includes/footer.php'; ?>