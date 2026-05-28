<?php
http_response_code(503);
define("APPURL", "http://localhost/E-Commerce/");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="Retry-After" content="3600">
  <title>503 - الموقع تحت الصيانة | متجرنا</title>
  <meta name="description" content="الموقع تحت الصيانة مؤقتاً. سنعود قريباً.">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/error.css">
</head>

<body>

  <div class="error-wrapper error-wrapper--info">

    <!-- Background shapes -->
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    <div class="bg-shape bg-shape-3"></div>

    <!-- Brand -->
    <a href="<?php echo APPURL; ?>index.php" class="error-brand">
      <i class="bi bi-bag-heart"></i>
      متجر<span>نا</span>
    </a>

    <div class="error-container animate-fadeInUp">

      <!-- Animated gear icon -->
      <div class="error-icon-wrap error-icon-wrap--gear">
        <span class="gear-spin"><i class="bi bi-gear-fill"></i></span>
      </div>

      <!-- Code -->
      <div class="error-code error-code--primary error-code--lg">503</div>

      <!-- Title & Description -->
      <h1 class="error-title">الموقع تحت الصيانة</h1>
      <p class="error-desc">
        نقوم حالياً بتحسين وتطوير خدماتنا لتقديم تجربة أفضل لك.<br>
        سنعود قريباً — شكراً لصبرك وتفهمك! 🙏
      </p>


      <!-- Action Buttons -->
      <div class="error-actions">
        <button onclick="location.reload()" class="btn btn-primary-custom px-4" id="checkBtn">
          <i class="bi bi-arrow-clockwise me-2"></i>
          تحقق مجدداً
        </button>
        <a href="<?php echo APPURL; ?>contact.php" class="btn btn-outline-custom px-4">
          <i class="bi bi-envelope me-2"></i>
          تواصل معنا
        </a>
      </div>

      <!-- Social -->
      <div class="social-row">
        <p>تابعنا للحصول على آخر المستجدات:</p>
        <a href="#" class="nav-icon-btn" style="width:36px;height:36px;font-size:0.95rem;" title="تويتر">
          <i class="bi bi-twitter-x"></i>
        </a>
        <a href="#" class="nav-icon-btn" style="width:36px;height:36px;font-size:0.95rem;" title="إنستغرام">
          <i class="bi bi-instagram"></i>
        </a>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>