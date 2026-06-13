<?php
$page_description = 'إضافة أو تعديل منتجات المتجر من لوحة التحكم.';
$page_title = 'إضافة منتج';
require_once 'config/config.php';
require_once 'includes/middleware/check-admin.php';


$product_id = isset($_GET['id']) ? max(0, (int) $_GET['id']) : 0;
$is_edit = $product_id > 0;
$product = null;

if ($is_edit) {
  $product_stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
  $product_stmt->execute([':product_id' => $product_id]);
  $product = $product_stmt->fetch(PDO::FETCH_OBJ);

  if (!$product) {
    setFlash('المنتج غير موجود', 'error');
    header('Location: ' . APPURL . 'admin_products.php');
    exit;
  }

  $page_title = 'تعديل المنتج';
}

$categories = $conn->prepare("SELECT * FROM categories ORDER BY name ASC");
$categories->execute();
$categories = $categories->fetchAll(PDO::FETCH_OBJ);

$form_error = $_SESSION['product_form_error'] ?? '';
unset($_SESSION['product_form_error']);

include 'includes/header.php';
?>

<body>
  <?php include 'includes/admin-sidebar.php'; ?>

  <main class="admin-content">
    <div class="admin-header">
      <div>
        <button class="btn btn-outline-custom d-lg-none" id="sidebarToggle" style="padding:0.4rem 0.7rem;">
          <i class="bi bi-list" style="font-size:1.25rem;"></i>
        </button>
        <h1 style="display:inline-block;vertical-align:middle;margin-right:var(--space-sm);">
          <?php echo $is_edit ? 'تعديل المنتج' : 'إضافة منتج جديد'; ?>
        </h1>
      </div>
      <a class="btn btn-outline-custom" href="<?php echo APPURL; ?>admin_products.php">
        <i class="bi bi-arrow-right me-2"></i>رجوع
      </a>
    </div>
    <?= displayFlash() ?>


    <?php if ($form_error): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($form_error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-lg);">
      <form method="post" enctype="multipart/form-data" action="<?php echo APPURL . ($is_edit ? 'actions/update_product.php' : 'actions/add_product.php'); ?>">
        <?php if ($is_edit): ?>
          <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
        <?php endif; ?>

        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label-custom" for="productName">اسم المنتج</label>
            <input type="text" class="form-control form-control-custom" id="productName" placeholder="أدخل اسم المنتج" name="name" value="<?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>

          <div class="col-md-4">
            <label class="form-label-custom" for="productCategory">التصنيف</label>
            <select class="form-select form-select-custom" id="productCategory" name="category_id" required>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->category_id; ?>" <?php echo ($is_edit && (int) $product->category_id === (int) $category->category_id) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label-custom" for="productPrice">السعر (ش)</label>
            <input type="number" class="form-control form-control-custom" id="productPrice" placeholder="0.00" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($product->price ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>

          <div class="col-md-4">
            <label class="form-label-custom" for="productStock">المخزون</label>
            <input type="number" class="form-control form-control-custom" id="productStock" placeholder="0" name="stock" min="0" value="<?php echo htmlspecialchars($product->stock_quantity ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>

          <div class="col-md-4">
            <label class="form-label-custom" for="productImage">صورة المنتج</label>
            <input type="file" class="form-control form-control-custom" id="productImage" accept="image/*" name="prodect_image" <?php echo $is_edit ? '' : 'required'; ?>>
          </div>

          <?php if ($is_edit && !empty($product->image_url)): ?>
            <div class="col-12">
              <label class="form-label-custom">الصورة الحالية</label>
              <div style="width:96px;height:96px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                <img src="<?php echo htmlspecialchars($product->image_url, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" style="width:100%;height:100%;object-fit:cover;">
              </div>
            </div>
          <?php endif; ?>

          <div class="col-12">
            <label class="form-label-custom" for="productDescription">وصف المنتج</label>
            <textarea class="form-control form-control-custom" id="productDescription" rows="4" placeholder="أدخل وصف المنتج ..." name="description" required><?php echo htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2" style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);margin-top:var(--space-lg);">
          <a class="btn btn-outline-custom" href="<?php echo APPURL; ?>admin_products.php">إلغاء</a>
          <button type="submit" class="btn btn-primary-custom" name="<?php echo $is_edit ? 'updateProductBtn' : 'saveProductBtn'; ?>">
            <i class="bi bi-check-lg me-2"></i><?php echo $is_edit ? 'حفظ التعديل' : 'حفظ المنتج'; ?>
          </button>
        </div>
      </form>
    </div>
  </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL . "js/main.js" ?>"></script>
</body>

</html>