<?php
$page_title = 'متجرنا — تفاصيل المنتج';
$page_description = 'تفاصيل المنتج — ساعة يد أنيقة بتصميم كلاسيكي. اطلع على المواصفات والسعر وأضف للسلة.';
include 'includes/header.php';
require 'config/config.php';


if(isset($_POST['add-to-cart'])){
  $user_id = $_SESSION['user_id'];
  if (!$user_id) {
    header('Location: auth/login.php');
    exit;
  }
    $product_id = $_POST['product_id'];
    $quantity_to_add = (int)$_POST['quantity'];
    
    $product_stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = :id");
    $product_stmt->execute(['id' => $product_id]);
    $product_data = $product_stmt->fetch(PDO::FETCH_OBJ);
    $current_stock = $product_data->stock_quantity;
    
    if($current_stock <= 0){
        echo "<script>alert('المنتج غير متوفر حالياً'); window.location.href = 'product-detail.php?id=$product_id';</script>";
        exit;
    }
    
    $sql = "SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_OBJ);
    
    $current_cart_quantity = $cart_item ? (int)$cart_item->quantity : 0;
    
    if ($current_stock < ($quantity_to_add + $current_cart_quantity)) {
        $allowed_to_add = $current_stock - $current_cart_quantity;
        if ($allowed_to_add > 0) {
            echo "<script>alert('لا يمكنك إضافة هذه الكمية. لديك $current_cart_quantity في السلة والمتبقي في المخزون يسمح بإضافة $allowed_to_add فقط.'); window.location.href = 'product-detail.php?id=$product_id';</script>";
        } else {
            echo "<script>alert('لقد أضفت الحد الأقصى المسموح به من هذا المنتج في سلتك.'); window.location.href = 'product-detail.php?id=$product_id';</script>";
        }
        exit;
    }
    
    if($cart_item){
        $sql = "UPDATE cart_items SET quantity = quantity + :quantity_to_add WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['quantity_to_add' => $quantity_to_add, 'user_id' => $user_id, 'product_id' => $product_id]);
        $msg = 'تمت زيادة كمية المنتج في السلة بنجاح';
    }else{
        $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity_to_add)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity_to_add' => $quantity_to_add]);
        $msg = 'تم إضافة المنتج للسلة بنجاح';
    }
    
    echo "<script>alert('$msg'); window.location.href = 'cart.php';</script>";
    exit;
}

$id = $_GET['id'] ;
if (!$id) {
  header('Location: errors/404.php');
  exit;
}
$product = $conn->prepare("SELECT * FROM products WHERE product_id = :id");
$product->execute(['id' => $id]);
$product = $product->fetch(PDO::FETCH_OBJ);


if (!$product) {
  header('Location: errors/404.php');
  exit;
}

$name = $product->name;
$price = $product->price;
$description = $product->description;
$image_url = $product->image_url;
$stock_quantity = $product->stock_quantity;
$category_id = $product->category_id;

$category = $conn->prepare("SELECT name FROM categories WHERE category_id = :category_id");
$category->execute(['category_id' => $category_id]);
$category = $category->fetch(PDO::FETCH_OBJ);

$category_name = $category->name;

$same_prodects = $conn->prepare("SELECT * FROM products WHERE category_id = :category_id AND product_id != :id ORDER BY created_at DESC LIMIT 4");
$same_prodects->execute(['category_id' => $category_id, 'id' => $id]);
$same_prodects = $same_prodects->fetchAll(PDO::FETCH_OBJ);
$count_same_prodects = count($same_prodects);


?>

<body>

  <?php include 'includes/navbar.php' ?>

  <div class="page-header">
    <div class="container">
      <h1>تفاصيل المنتج</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <a href="products.php">المنتجات</a>
        <span class="separator">/</span>
        <span><?php echo $name ?></span>
      </div>
    </div>
  </div>

  <section class="section-padding">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6">
          <div class="product-gallery animate-fadeInUp shadow-sm bg-white" style="border: 1px solid var(--color-border-light); padding: 2rem;">
            <img src="<?php echo htmlspecialchars($image_url) ?>" alt="<?php echo htmlspecialchars($name) ?>" id="mainProductImage" class="img-fluid rounded-3" style="max-height: 500px; object-fit: contain;">
          </div>
        </div>
         
        <div class="col-lg-6">
          <div class="product-info animate-fadeInUp delay-2">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="product-category-label px-3 py-1 bg-primary-light text-primary-custom rounded-pill d-inline-block fw-bold"><?php echo htmlspecialchars($category_name) ?></div>
            </div>
            <h1 class="fw-bold mb-3" style="color: var(--color-text); font-size: 2.2rem;"><?php echo htmlspecialchars($name) ?></h1>
            
            <div class="product-detail-price mb-4" style="font-size: 2.2rem; color: var(--color-primary); font-weight: 800;"><?php echo htmlspecialchars($price) ?> <span class="fs-5 text-muted fw-normal">شيكل</span></div>

            <p class="product-description text-secondary fs-6 mb-4" style="line-height: 1.8;">
              <?php echo nl2br(htmlspecialchars($description)) ?>
            </p>

            <div class="d-flex align-items-center gap-2 mb-4">
              <?php if ($stock_quantity > 0): ?>
                <span class="status-badge bg-success-light text-success-custom px-3 py-2 rounded-pill shadow-sm" style="font-weight: 600;">
                  <i class="bi bi-check-circle-fill me-1"></i> متوفر في المخزون (<?php echo $stock_quantity; ?>)
                </span>
              <?php else: ?>
                <span class="status-badge bg-danger-light text-danger-custom px-3 py-2 rounded-pill shadow-sm" style="font-weight: 600;">
                  <i class="bi bi-x-circle-fill me-1"></i> غير متوفر حالياً
                </span>
              <?php endif; ?>
            </div>

            <form action="product-detail.php" method="POST" class="bg-white p-3 rounded-4 shadow-sm mb-4" style="border: 1px solid var(--color-border-light);">
              <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="quantity-control">
                  <button class="qty-minus" name="remove" type="button">−</button>
                  <input type="number" value="1" min="1" name="quantity" id="productQuantity" max="<?php echo $stock_quantity ?>">
                  <button class="qty-plus" name="add" type="button" <?php if($stock_quantity <= 1){ echo 'disabled'; } ?>>+</button>
                </div>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold d-flex align-items-center justify-content-center flex-grow-1" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-hover) 100%); border: none; box-shadow: 0 4px 12px rgba(106, 173, 207, 0.25); height: 48px; border-radius: var(--radius-md);" id="addToCartBtn" <?php if($stock_quantity <= 0){ echo 'disabled'; } ?>>
                  <i class="bi bi-bag-plus fs-5 ms-2"></i>
                  إضافة للسلة
                </button>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->product_id) ?>">
                <input type="hidden" name="add-to-cart" value="1">
              </div>
            </form>

            <div class="mt-4 pt-4 border-top border-light">
              <div class="bg-light rounded-4 p-4">
                <div class="row g-4">
                  <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-truck text-primary fs-5"></i>
                      </div>
                      <span class="fw-semibold text-secondary" style="font-size: 0.95rem;">شحن سريع</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-arrow-repeat text-primary fs-5"></i>
                      </div>
                      <span class="fw-semibold text-secondary" style="font-size: 0.95rem;">استرجاع سهل</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-shield-check text-primary fs-5"></i>
                      </div>
                      <span class="fw-semibold text-secondary" style="font-size: 0.95rem;">ضمان سنتين</span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center gap-3">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-credit-card text-primary fs-5"></i>
                      </div>
                      <span class="fw-semibold text-secondary" style="font-size: 0.95rem;">دفع إلكتروني آمن</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if ($count_same_prodects > 0) { ?>
      <!-- Related Products -->
      <div class="mt-5 pt-5 border-top border-light">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h2 class="h3 fw-bold mb-0 text-dark">منتجات ذات صلة</h2>
          <a href="products.php?category=<?php echo htmlspecialchars($category_id); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm transition-base d-flex align-items-center">
            عرض المزيد <i class="bi bi-arrow-left ms-2"></i>
          </a>
        </div>
        <div class="row g-4">
          <?php foreach ($same_prodects as $same_prodect) : ?>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card-custom product-card">
              <div class="product-img-wrapper">
                <img src="<?php echo $same_prodect->image_url ?>" alt="<?php echo $same_prodect->name ?>">
              </div>
              <div class="card-body">
                <div class="product-category"><?php echo $category_name ?></div>
                <h6 class="product-title"><a href="product-detail.php?id=<?php echo $same_prodect->product_id ?>"><?php echo $same_prodect->name ?></a></h6>
                <div class="product-price"><?php echo $same_prodect->price ?> ش</div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php } ?>
    </div>
  </section>
  <?php include 'includes/footer.php'; ?>