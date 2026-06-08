<?php
$page_description = 'إدارة المنتجات — إضافة وتعديل وحذف المنتجات في المتجر.';
$page_title = 'إدارة المنتجات';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$products_per_page = 6;
$total_products = (int) $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_pages = max(1, (int) ceil($total_products / $products_per_page));
$current_page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

if ($current_page > $total_pages) {
  $current_page = $total_pages;
}

$offset = ($current_page - 1) * $products_per_page;
$start_product = $total_products > 0 ? $offset + 1 : 0;
$end_product = min($offset + $products_per_page, $total_products);

$products_stmt = $conn->prepare("
    SELECT 
        cat.name AS category_name, 
        p.name, 
        p.price, 
        p.stock_quantity, 
        p.product_id, 
        p.image_url 
    FROM products p
    LEFT JOIN categories cat ON cat.category_id = p.category_id
    ORDER BY p.product_id DESC
    LIMIT :limit OFFSET :offset
");
$products_stmt->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$products_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$products_stmt->execute();
$products = $products_stmt->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <?php include 'includes/admin-sidebar.php'; ?>

  <main class="admin-content">
    <div class="admin-header">
      <div>
        <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
          <i class="bi bi-list" style="font-size:1.25rem;"></i>
        </button>
        <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">إدارة المنتجات</h1>
      </div>
      <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addProductModal" id="addProductBtn">
        <i class="bi bi-plus-lg me-2"></i>إضافة منتج
      </button>
    </div>

    <div class="card-custom" style="padding:var(--space-lg);border-radius:var(--radius-lg);margin-bottom:var(--space-xl);">
      <div class="row g-3 align-items-end">
        <div class="col-md-5">
          <label class="form-label-custom">بحث</label>
          <input type="text" class="form-control form-control-custom" placeholder="ابحث عن منتج ..." id="adminProductSearch">
        </div>
        <div class="col-md-3">
          <label class="form-label-custom">التصنيف</label>
          <select class="form-select form-select-custom" id="adminProductCategory">
            <option>الكل</option>
            <option>إلكترونيات</option>
            <option>إكسسوارات</option>
            <option>أحذية</option>
            <option>حقائب</option>
            <option>عطور</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label-custom">الحالة</label>
          <select class="form-select form-select-custom" id="adminProductStatus">
            <option>الكل</option>
            <option>متوفر</option>
            <option>نفذ</option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-custom w-100" id="adminProductFilterBtn">
            <i class="bi bi-funnel me-1"></i>تصفية
          </button>
        </div>
      </div>
    </div>

    <div class="card-custom" style="border-radius:var(--radius-lg);overflow:hidden;">
      <div class="table-responsive">
        <table class="table table-custom mb-0" id="adminProductsTable">
          <thead>
            <tr>
              <th style="width:5%;">#</th>
              <th style="width:8%;">الصورة</th>
              <th>اسم المنتج</th>
              <th>التصنيف</th>
              <th>السعر</th>
              <th>المخزون</th>
              <th style="width:15%;">الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($products) === 0): ?>
              <tr>
                <td colspan="7" class="text-center py-4">لا توجد منتجات.</td>
              </tr>
            <?php endif; ?>
            <?php
            foreach ($products as $product) : ?>
              <tr>
                <td><?= $product->product_id ?></td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="<?= $product->image_url ?>" alt="<?= $product->name ?>" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong><?= $product->name ?></strong></td>
                <td><?= $product->category_name ?></td>
                <td><?= $product->price ?> ش</td>
                <td><?= $product->stock_quantity ?></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <form action="admin_products.php" method="POST">
                      <input type="hidden" name="prod_id" value="<?php echo $product->product_id ?>">
                      <button type="submit" name="delete-product" class="btn btn-danger-soft btn-remove-item" title="حذف">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
      <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">
        عرض <?php echo $start_product; ?> إلى <?php echo $end_product; ?> من <?php echo $total_products; ?> منتج
      </p>

      <?php if ($total_pages > 1): ?>
        <nav>
          <?php
          $page_get = $_GET;
          unset($page_get['page']);
          $base_q = http_build_query($page_get);
          $base_url = 'admin_products.php?' . ($base_q ? $base_q . '&' : '');
          $max_visible = 5;
          $start_page = max(1, $current_page - floor($max_visible / 2));
          $end_page = min($total_pages, $start_page + $max_visible - 1);
          $start_page = max(1, $end_page - $max_visible + 1);
          ?>
          <ul class="pagination mb-0" style="gap:4px;">
            <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
              <a class="page-link border-0 rounded-3" href="<?php echo ($current_page > 1) ? $base_url . 'page=' . ($current_page - 1) : '#'; ?>" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a>
            </li>

            <?php if ($start_page > 1): ?>
              <li class="page-item">
                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=1" style="color:var(--color-text-secondary);">1</a>
              </li>
              <?php if ($start_page > 2): ?>
                <li class="page-item disabled">
                  <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
                </li>
              <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
              <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $i; ?>" style="<?php echo ($i === $current_page) ? 'background:var(--color-primary);border-color:var(--color-primary);' : 'color:var(--color-text-secondary);'; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($end_page < $total_pages): ?>
              <?php if ($end_page < $total_pages - 1): ?>
                <li class="page-item disabled">
                  <span class="page-link border-0 rounded-3" style="color:var(--color-text-muted);">...</span>
                </li>
              <?php endif; ?>
              <li class="page-item">
                <a class="page-link border-0 rounded-3" href="<?php echo $base_url; ?>page=<?php echo $total_pages; ?>" style="color:var(--color-text-secondary);"><?php echo $total_pages; ?></a>
              </li>
            <?php endif; ?>

            <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
              <a class="page-link border-0 rounded-3" href="<?php echo ($current_page < $total_pages) ? $base_url . 'page=' . ($current_page + 1) : '#'; ?>" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </main>
  </div>

  <div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="border:none;border-radius:var(--radius-xl);">
        <div class="modal-header" style="border-bottom:1px solid var(--color-border-light);padding:var(--space-xl);">
          <h5 class="modal-title" style="font-weight:700;">
            <i class="bi bi-plus-circle ms-2 text-primary-custom"></i>إضافة منتج جديد
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="padding:var(--space-xl);">
          <form id="addProductForm" method="post" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label-custom" for="newProductName">اسم المنتج</label>
                <input type="text" class="form-control form-control-custom" id="newProductName" placeholder="أدخل اسم المنتج" name="name">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductCategory">التصنيف</label>
                <select class="form-select form-select-custom" id="newProductCategory" name="category_id">
                  <?php
                  $categories = $conn->prepare("SELECT * FROM categories");
                  $categories->execute();
                  $categories = $categories->fetchAll(PDO::FETCH_OBJ);
                  foreach ($categories as $category) : ?>
                    <option value="<?= $category->category_id ?>"><?= $category->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductPrice">السعر (ش)</label>
                <input type="number" class="form-control form-control-custom" id="newProductPrice" placeholder="0.00" name="price">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductStock">المخزون</label>
                <input type="number" class="form-control form-control-custom" id="newProductStock" placeholder="0" name="stock">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductImage">صورة المنتج</label>
                <input type="file" class="form-control form-control-custom" id="newProductImage" accept="image/*" name="prodect_image">

              </div>
              <div class="col-12">
                <label class="form-label-custom" for="newProductDescription">وصف المنتج</label>
                <textarea class="form-control form-control-custom" id="newProductDescription" rows="4" placeholder="أدخل وصف المنتج ..." name="description"></textarea>
              </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--color-border-light);padding:var(--space-lg) var(--space-xl);margin-top:var(--space-lg);">
              <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">إلغاء</button>
              <button type="submit" class="btn btn-primary-custom" id="saveProductBtn" name="saveProductBtn">
                <i class="bi bi-check-lg me-2"></i>حفظ المنتج
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL . "js/main.js" ?>"></script>
</body>

</html>
