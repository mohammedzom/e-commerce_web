<?php
$page_description = 'إدارة المنتجات — إضافة وتعديل وحذف المنتجات في المتجر.';
$page_title = 'إدارة المنتجات';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';
include 'includes/header.php';

$products_per_page = 10;
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

$page_get = $_GET;
unset($page_get['page']);
$base_q = http_build_query($page_get);
$base_url = 'admin_products.php?' . ($base_q ? $base_q . '&' : '');
$max_visible = 5;
$start_page = max(1, $current_page - floor($max_visible / 2));
$end_page = min($total_pages, $start_page + $max_visible - 1);
$start_page = max(1, $end_page - $max_visible + 1);

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
      <a class="btn btn-primary-custom" href="<?php echo APPURL; ?>admin_product_form.php" id="addProductBtn">
        <i class="bi bi-plus-lg me-2"></i>إضافة منتج
      </a>
    </div>
    <?= displayFlash() ?>



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
            <?php if (count($products) == 0): ?>
              <tr>
                <td colspan="7" class="text-center py-4">لا توجد منتجات.</td>
              </tr>
            <?php endif; ?>
            <?php
            $i = ($current_page - 1) * $products_per_page + 1;
            foreach ($products as $product): ?>
              <tr>
                <td data-label="#"> <?= $i++ ?></td>
                <td data-label="الصورة">
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="<?= htmlspecialchars($product->image_url) ?>" alt="<?= htmlspecialchars($product->name) ?>" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td data-label="اسم المنتج"><strong><?= htmlspecialchars($product->name) ?></strong></td>
                <td data-label="التصنيف"><?= htmlspecialchars($product->category_name ?? 'بدون تصنيف') ?></td>
                <td data-label="السعر"><?= htmlspecialchars($product->price) ?> ش</td>
                <td data-label="المخزون"><?= htmlspecialchars($product->stock_quantity) ?></td>
                <td data-label="الإجراءات">
                  <div class="d-flex gap-1">
                    <a class="btn btn-outline-custom btn-sm-custom" href="<?php echo APPURL; ?>admin_product_form.php?id=<?php echo $product->product_id; ?>" title="تعديل"><i class="bi bi-pencil"></i></a>
                    <form action="<?php echo APPURL; ?>actions/delete_product.php" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                      <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
                      <input type="hidden" name="page" value="<?php echo $current_page; ?>">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL . "js/main.js" ?>"></script>
</body>

</html>