<?php
$page_title = 'متجرنا — سلة المشتريات';
$page_description = 'سلة المشتريات — راجع منتجاتك وأكمل عملية الشراء بسهولة.';
require_once 'config/config.php';
require_once 'includes/middleware/check-login.php';
include 'includes/header.php';


$user_id = $_SESSION['user_id'];
$cart_items = $conn->prepare("
  SELECT 
    c.name as category_name, 
    ci.quantity as cart_quantity, 
    p.* , 
    ci.cart_id as cart_id  
  FROM cart_items ci
  INNER JOIN products p ON ci.product_id = p.product_id 
  INNER JOIN categories c ON p.category_id = c.category_id 
  WHERE ci.user_id = :user_id");
$cart_items->execute(['user_id' => $user_id]);
$cart_items = $cart_items->fetchAll(PDO::FETCH_OBJ);

$count_cart_items = count($cart_items);

$total = 0;
foreach ($cart_items as $cart_item) {
  $total += $cart_item->price * $cart_item->cart_quantity;
}

?>

<body>

  <!-- NAVBAR -->
  <?php include 'includes/navbar.php' ?>

  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="container">
      <h1>سلة المشتريات</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <span>سلة المشتريات</span>
      </div>
    </div>
  </div>

  <!-- CART CONTENT -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-4">
        <!-- Cart Table -->
        <div class="col-lg-8">
          <div class="table-responsive table-custom">
            <table class="table mb-0" id="cartTable">
              <thead>
                <tr>
                  <th style="width:50%;">المنتج</th>
                  <th>السعر</th>
                  <th>الكمية</th>
                  <th>الإجمالي</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($cart_items) == 0) { ?>
                  <tr>
                    <td colspan="5" class="text-center">لا توجد منتجات في السلة</td>
                  </tr>
                <?php } ?>
                <?php foreach ($cart_items as $cart_item): ?>

                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <div style="width:64px;height:64px;border-radius:var(--radius-md);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                          <img src="<?php echo $cart_item->image_url ?>" alt="<?php echo $cart_item->name ?>" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div>
                          <h6 style="font-size:var(--font-size-sm);font-weight:600;margin-bottom:2px;"><?php echo $cart_item->name ?></h6>
                          <span style="font-size:var(--font-size-xs);color:var(--color-text-muted);"><?php echo $cart_item->category_name ?></span>
                        </div>
                      </div>
                    </td>
                    <td style="white-space:nowrap;"><?php echo $cart_item->price ?> ش</td>
                    <form action="<?php echo APPURL; ?>actions/update_cart.php" method="POST">
                      <td>
                        <div class="quantity-control">
                          <button class="qty-minus" type="button">−</button>
                          <input type="number" value="<?php echo $cart_item->cart_quantity ?>" min="1" max="<?php echo $cart_item->stock_quantity ?>" name="new_quantity">
                          <button class="qty-plus" type="button">+</button>
                        </div>
                      </td>
                      <td style="white-space:nowrap;font-weight:600;"><?php echo $cart_item->price * $cart_item->cart_quantity ?> ش</td>
                      <td style="display: flex; flex-direction: column; gap: 10px;">

                        <input type="hidden" name="cart_id" value="<?php echo $cart_item->cart_id ?>">
                        <button type="submit" name="apply-from-cart" class="btn btn-success-soft btn-remove-item" title="تطبيق">
                          <i class="bi bi-check"></i>
                        </button>
                    </form>

                    <form action="<?php echo APPURL; ?>actions/remove_from_cart.php" method="POST">
                      <input type="hidden" name="cart_item_id" value="<?php echo $cart_item->cart_id ?>">
                      <button type="submit" name="remove-from-cart" class="btn btn-danger-soft btn-remove-item" title="حذف">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            <a href="products.php" class="btn btn-outline-custom">
              <i class="bi bi-arrow-right me-2"></i>
              متابعة التسوق
            </a>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cart-summary" id="cartSummary">
            <h5><i class="bi bi-receipt ms-2"></i>ملخص الطلب</h5>
            <div class="cart-summary-row">
              <span>المجموع الفرعي</span>
              <span><?php echo $total ?> ش</span>
            </div>
            <div class="cart-summary-row">
              <span>الشحن</span>
              <span style="color:var(--color-success);">مجاني</span>
            </div>
            <div class="cart-summary-row">
              <span>الضريبة (1%)</span>
              <span><?php echo $total * 0.01 ?> ش</span>
            </div>
            <div class="cart-summary-row total">
              <span>الإجمالي</span>
              <span style="color:var(--color-primary);"><?php echo $total ?> ش</span>
            </div>


            <form action="actions/checkout.php" method="POST">
              <button class="btn btn-primary-custom w-100 mt-4" id="checkoutBtn">
                <i class="bi bi-lock me-2"></i>
                إتمام الطلب
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include 'includes/footer.php' ?>