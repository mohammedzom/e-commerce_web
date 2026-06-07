<?php
$page_title = 'متجرنا — تفاصيل المنتج';
$page_description = 'تفاصيل المنتج — ساعة يد أنيقة بتصميم كلاسيكي. اطلع على المواصفات والسعر وأضف للسلة.';
include 'includes/header.php';
require 'config/config.php';


if(isset($_POST['add-to-cart'])){
  // exit;
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

  <!-- NAVBAR -->
  <?php include 'includes/navbar.php' ?>

  <!-- PAGE HEADER -->
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

  <!-- PRODUCT DETAIL -->
  <section class="section-padding">
    <div class="container">
      <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
          <div class="product-gallery animate-fadeInUp">
            <img src="<?php echo $image_url ?>" alt="<?php $name ?>" id="mainProductImage">
          </div>
         

        <!-- Product Info -->
        <div class="col-lg-6">
          <div class="product-info animate-fadeInUp delay-2">
            <div class="product-category-label"><?php echo $category_name ?></div>
            <h1><?php echo $name ?></h1>

            
            <div class="product-detail-price"><?php echo $price ?> ش</div>

            <p class="product-description">
              <?php echo $description ?>
            </p>

            <div class="d-flex align-items-center gap-2 mb-4">
              <span class="status-badge status-completed"><i class="bi bi-check-circle-fill"></i> متوفر في المخزون</span>
            </div>

            <form action="product-detail.php" method="POST">
            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
              <div class="quantity-control">
                <button class="qty-minus" type="button">−</button>
                <input type="number" value="1" min="1" name="quantity" id="productQuantity" max="<?php echo $stock_quantity ?>">
                <button class="qty-plus" type="button" <?php if($stock_quantity <= 0){ echo 'disabled'; } ?>>+</button>
              </div>
              <button type="submit" class="btn btn-primary-custom px-4" id="addToCartBtn" <?php if($stock_quantity <= 0){ echo 'disabled'; } ?>>
                <i class="bi bi-bag-plus me-2"></i>
                إضافة للسلة
              </button>
              <input type="hidden" name="product_id" value="<?php echo $product->product_id ?>">
              <input type="hidden" name="add-to-cart" value="1">
            </div>
            </form>

            <div style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);">
              <div class="d-flex gap-4 flex-wrap" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                <div><strong style="color:var(--color-text);">التصنيف:</strong> <?php echo $category_name ?></div>
              </div>
            </div>
            <div style="border-top:1px solid var(--color-border-light);padding-top:var(--space-lg);margin-top:var(--space-lg);">
              <div class="row g-3">
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-truck text-primary-custom"></i>
                    <span>شحن مجاني</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-arrow-repeat text-primary-custom"></i>
                    <span>استرجاع خلال 14 يوم</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-shield-check text-primary-custom"></i>
                    <span>ضمان سنتين</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);">
                    <i class="bi bi-credit-card text-primary-custom"></i>
                    <span>دفع آمن</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if ($count_same_prodects > 0) { ?>
      <!-- Related Products -->
      <div class="mt-5 pt-4" style="border-top:1px solid var(--color-border-light);">
        <div class="section-header">
          <h2 class="section-title" style="font-size:var(--font-size-xl);">منتجات ذات صلة</h2>
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