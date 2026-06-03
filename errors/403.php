<?php
http_response_code(403);
define("APPURL", "http://localhost/E-Commerce/");
require_once '../includes/handlers/auth-handler.php';

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>403 - وصول مرفوض | متجرنا</title>
  <meta name="description" content="عذراً، ليس لديك صلاحية للوصول إلى هذه الصفحة.">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/error.css">
</head>

<body>

  <div class="error-wrapper error-wrapper--warning">

    <!-- Brand -->
    <a href="<?php echo APPURL; ?>index.php" class="error-brand">
      <i class="bi bi-bag-heart"></i>
      متجر<span>نا</span>
    </a>

    <div class="error-container animate-fadeInUp">

      <!-- Icon -->
      <div class="error-icon-wrap error-icon-wrap--shake">
        <i class="bi bi-shield-lock"></i>
      </div>

      <!-- Code -->
      <div class="error-code error-code--warning">403</div>

      <!-- Title & Description -->
      <h1 class="error-title">وصول مرفوض</h1>
      <p class="error-desc">
        عذراً، ليس لديك الصلاحيات الكافية للوصول إلى هذه الصفحة.<br>
        إذا كنت تعتقد أن هذا خطأ، يرجى تسجيل الدخول أو التواصل معنا.
      </p>

      <!-- Info box -->
      <div class="error-info-box">
        <i class="bi bi-info-circle"></i>
        <?php if (!checkLogin()) : ?>
          <p>
            قد تكون هذه الصفحة مخصصة للمشرفين فقط، أو تحتاج إلى تسجيل الدخول أولاً للمتابعة.
          </p>
        <?php else : ?>
          <p>
            ليس لديك صلاحية الوصول إلى هذه الصفحة.
          </p>
        <?php endif; ?>
      </div>

      <!-- Action Buttons -->
      <div class="error-actions">
        <?php if (!checkLogin()) : ?>
          <a href="<?php echo APPURL; ?>auth/login.php" class="btn btn-warning-custom px-4">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            تسجيل الدخول
          </a>
        <?php endif; ?>
        <a href="<?php echo APPURL; ?>index.php" class="btn btn-outline-custom px-4">
          <i class="bi bi-house-door me-2"></i>
          الرئيسية
        </a>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>