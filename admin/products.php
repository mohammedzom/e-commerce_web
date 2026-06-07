<?php
$page_description = 'إدارة المنتجات — إضافة وتعديل وحذف المنتجات في المتجر.';
$page_title = 'إدارة المنتجات';
include '../includes/header.php';
require '../config/config.php';
require_once '../includes/middleware/check-admin.php';



if (isset($_POST['saveProductBtn'])) {
  try {
    $target_dir = __DIR__ . "/../assets/uploads/images/";

    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["prodect_image"]["name"], PATHINFO_EXTENSION));

    $unique_name = uniqid('product_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;

    $uploadOk = 1;

    $check = getimagesize($_FILES["prodect_image"]["tmp_name"]);
    if ($check === false) {
      $uploadOk = 0;
    }

    // 1mb max
    if ($_FILES["prodect_image"]["size"] > 1000000) {
      $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif") {
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      $statuts = "فشل رفع الصورة — تأكد من نوع الملف وحجمه";
    } else {
      if (move_uploaded_file($_FILES["prodect_image"]["tmp_name"], $target_file)) {
        $image_url = APPURL . "assets/uploads/images/" . $unique_name;

        $product = [
          'name' => $_POST['name'],
          'description' => $_POST['description'],
          'price' => $_POST['price'],
          'stock_quantity' => $_POST['stock'],
          'category_id' => $_POST['category_id'],
          'image_url' => $image_url,
        ];

        $result = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, category_id, image_url) VALUES (:name, :description, :price, :stock_quantity, :category_id, :image_url)")
          ->execute($product);
        $statuts = $result ? "تم إضافة المنتج بنجاح" : "فشل إضافة المنتج";
      } else {
        $statuts = "حدث خطأ أثناء رفع الملف";
      }
    }
  } catch (Exception $e) {
    $statuts = "حدث خطأ: " . $e->getMessage();
  }
  echo "<script>alert('$statuts')</script>";
}
if (isset($_POST['delete-product'])) {
  $product_id = $_POST['prod_id'];
  $statuts = $conn->prepare("DELETE FROM products WHERE product_id = :product_id")
    ->execute([':product_id' => $product_id]);
  $statuts = $statuts ? "تم حذف المنتج بنجاح" : "فشل حذف المنتج";
  echo "<script>alert('$statuts')</script>";
}
$products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_OBJ);
?>

<body>
  <div class="admin-wrapper">
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:999;"></div>

    <?php include '../includes/admin-sidebar.php'; ?>

    <!-- MAIN CONTENT -->
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

      <!-- Products Table -->
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
                  <td><?= $product->category ?></td>
                  <td><?= $product->price ?> ش</td>
                  <td><?= $product->stock_quantity ?></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                      <form action="products.php" method="POST">
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
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">عرض 1 إلى 6 من 524 منتج</p>
        <nav>
          <ul class="pagination mb-0" style="gap:4px;">
            <li class="page-item disabled"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-muted);"><i class="bi bi-chevron-right"></i></a></li>
            <li class="page-item active"><a class="page-link border-0 rounded-3" href="#" style="background:var(--color-primary);border-color:var(--color-primary);">1</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">2</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);">3</a></li>
            <li class="page-item"><a class="page-link border-0 rounded-3" href="#" style="color:var(--color-text-secondary);"><i class="bi bi-chevron-left"></i></a></li>
          </ul>
        </nav>
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