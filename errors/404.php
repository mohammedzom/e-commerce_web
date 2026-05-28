<?php
http_response_code(404);
define("APPURL", "http://localhost/E-Commerce/");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>404 - الصفحة غير موجودة | متجرنا</title>
  <meta name="description" content="عذراً، الصفحة التي تبحث عنها غير موجودة.">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/error.css">
</head>

<body>

  <div class="error-wrapper">

    <!-- Brand -->
    <a href="<?php echo APPURL; ?>index.php" class="error-brand">
      <i class="bi bi-bag-heart"></i>
      متجر<span>نا</span>
    </a>

    <div class="error-container animate-fadeInUp">

      <!-- Icon -->
      <div class="error-icon-wrap error-icon-wrap--pulse">
        <i class="bi bi-search"></i>
      </div>

      <!-- Code -->
      <div class="error-code error-code--primary">404</div>

      <!-- Title & Description -->
      <h1 class="error-title">الصفحة غير موجودة</h1>
      <p class="error-desc">
        عذراً، الصفحة التي تبحث عنها لا وجود لها أو ربما تم نقلها.<br>
        تحقق من الرابط أو عُد إلى الصفحة الرئيسية.
      </p>

      <!-- Action Buttons -->
      <div class="error-actions">
        <a href="<?php echo APPURL; ?>index.php" class="btn btn-primary-custom px-4">
          <i class="bi bi-house-door me-2"></i>
          الرئيسية
        </a>
        <a href="<?php echo APPURL; ?>products.php" class="btn btn-outline-custom px-4">
          <i class="bi bi-bag me-2"></i>
          تصفح المنتجات
        </a>
      </div>

      <!-- Helpful Links -->
      <div class="helpful-links">
        <p>قد تجد ما تبحث عنه هنا:</p>
        <div class="helpful-links-list">
          <a href="<?php echo APPURL; ?>products.php">
            <i class="bi bi-grid"></i> المنتجات
          </a>
          <a href="<?php echo APPURL; ?>cart.php">
            <i class="bi bi-cart3"></i> السلة
          </a>
          <a href="<?php echo APPURL; ?>contact.php">
            <i class="bi bi-chat-dots"></i> تواصل معنا
          </a>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
