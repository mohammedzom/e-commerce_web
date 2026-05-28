<?php
$page_description = 'إدارة المنتجات — إضافة وتعديل وحذف المنتجات في المتجر.';
$page_title = 'إدارة المنتجات';
include '../includes/header.php';
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location:../" . APPURL . "/admin/login.php");
} else {
  $session_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
  $user = $conn->prepare("SELECT * FROM admins WHERE id=:session_id");
  $user->execute(['session_id' => $session_id]);
  $user = $user->fetch(PDO::FETCH_OBJ);

  if ($user->role != 'admin') {
    header("Location:../" . APPURL . "/");
  }
}

?>

<body>
  <div class="admin-wrapper">
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:999;"></div>

    <!-- SIDEBAR -->
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

      <!-- Search & Filter -->
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
                <th>الحالة</th>
                <th style="width:15%;">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60&h=60&fit=crop" alt="ساعة" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>ساعة يد أنيقة بتصميم كلاسيكي</strong></td>
                <td>إكسسوارات</td>
                <td>299 ر.س</td>
                <td>45</td>
                <td><span class="status-badge status-completed">متوفر</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=60&h=60&fit=crop" alt="سماعات" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>سماعات لاسلكية عالية الجودة</strong></td>
                <td>إلكترونيات</td>
                <td>349 ر.س</td>
                <td>120</td>
                <td><span class="status-badge status-completed">متوفر</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=60&h=60&fit=crop" alt="حذاء" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>حذاء رياضي مريح وعصري</strong></td>
                <td>أحذية</td>
                <td>199 ر.س</td>
                <td>0</td>
                <td><span class="status-badge status-cancelled">نفذ</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=60&h=60&fit=crop" alt="كاميرا" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>كاميرا بولارويد بتصميم ريترو</strong></td>
                <td>إلكترونيات</td>
                <td>549 ر.س</td>
                <td>28</td>
                <td><span class="status-badge status-completed">متوفر</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=60&h=60&fit=crop" alt="عطر" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>عطر فاخر بتركيبة فرنسية</strong></td>
                <td>عطور</td>
                <td>280 ر.س</td>
                <td>65</td>
                <td><span class="status-badge status-completed">متوفر</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>
                  <div style="width:44px;height:44px;border-radius:var(--radius-sm);overflow:hidden;background:var(--color-bg-alt);">
                    <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=60&h=60&fit=crop" alt="حقيبة" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                </td>
                <td><strong>حقيبة جلدية فاخرة</strong></td>
                <td>حقائب</td>
                <td>420 ر.س</td>
                <td>15</td>
                <td><span class="status-badge status-completed">متوفر</span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-outline-custom btn-sm-custom" title="تعديل"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger-soft" title="حذف"><i class="bi bi-trash3"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
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

  <!-- ADD PRODUCT MODAL -->
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
          <form id="addProductForm">
            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label-custom" for="newProductName">اسم المنتج</label>
                <input type="text" class="form-control form-control-custom" id="newProductName" placeholder="أدخل اسم المنتج">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductCategory">التصنيف</label>
                <select class="form-select form-select-custom" id="newProductCategory">
                  <option>إلكترونيات</option>
                  <option>إكسسوارات</option>
                  <option>أحذية</option>
                  <option>حقائب</option>
                  <option>عطور</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductPrice">السعر (ر.س)</label>
                <input type="number" class="form-control form-control-custom" id="newProductPrice" placeholder="0.00">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductStock">المخزون</label>
                <input type="number" class="form-control form-control-custom" id="newProductStock" placeholder="0">
              </div>
              <div class="col-md-4">
                <label class="form-label-custom" for="newProductImage">صورة المنتج</label>
                <input type="file" class="form-control form-control-custom" id="newProductImage" accept="image/*">
              </div>
              <div class="col-12">
                <label class="form-label-custom" for="newProductDescription">وصف المنتج</label>
                <textarea class="form-control form-control-custom" id="newProductDescription" rows="4" placeholder="أدخل وصف المنتج ..."></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer" style="border-top:1px solid var(--color-border-light);padding:var(--space-lg) var(--space-xl);">
          <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-primary-custom" id="saveProductBtn">
            <i class="bi bi-check-lg me-2"></i>حفظ المنتج
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>