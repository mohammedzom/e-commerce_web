<?php
http_response_code(500);
define("APPURL", "http://localhost/E-Commerce/");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>500 - خطأ في الخادم | متجرنا</title>
  <meta name="description" content="عذراً، حدث خطأ داخلي في الخادم. نعمل على إصلاحه.">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/error.css">
</head>

<body>

  <div class="error-wrapper error-wrapper--danger">

    <!-- Brand -->
    <a href="<?php echo APPURL; ?>index.php" class="error-brand">
      <i class="bi bi-bag-heart"></i>
      متجر<span>نا</span>
    </a>

    <div class="error-container animate-fadeInUp">

      <!-- Icon -->
      <div class="error-icon-wrap error-icon-wrap--glitch">
        <i class="bi bi-exclamation-triangle"></i>
      </div>

      <!-- Code -->
      <div class="error-code error-code--danger">500</div>

      <!-- Title & Description -->
      <h1 class="error-title">خطأ داخلي في الخادم</h1>
      <p class="error-desc">
        حدث خطأ غير متوقع من جانبنا. فريقنا التقني على علم بالمشكلة<br>
        ويعمل على إصلاحها في أقرب وقت ممكن.
      </p>

      <!-- Status Steps -->
      <div class="status-steps">
        <h6><i class="bi bi-activity me-1"></i> حالة النظام</h6>
        <div class="status-step">
          <span class="step-dot ok"></span>
          <span class="step-label">الاتصال بالشبكة</span>
          <span class="step-status ok">يعمل ✓</span>
        </div>
        <div class="status-step">
          <span class="step-dot ok"></span>
          <span class="step-label">خادم الويب</span>
          <span class="step-status ok">يعمل ✓</span>
        </div>
        <div class="status-step">
          <span class="step-dot error"></span>
          <span class="step-label">معالجة الطلب</span>
          <span class="step-status error">خطأ ✗</span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="error-actions">
        <button onclick="location.reload()" class="btn btn-danger-custom px-4" id="reloadBtn">
          <i class="bi bi-arrow-clockwise me-2"></i>
          إعادة المحاولة
        </button>
        <a href="<?php echo APPURL; ?>index.php" class="btn btn-outline-custom px-4">
          <i class="bi bi-house-door me-2"></i>
          الرئيسية
        </a>
      </div>

      <!-- Reload hint with countdown -->
      <p class="reload-hint">
        سيتم إعادة المحاولة تلقائياً خلال <strong id="countdown">30</strong> ثانية
      </p>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto-reload countdown
    let seconds = 30;
    const countdownEl = document.getElementById('countdown');
    const timer = setInterval(() => {
      seconds--;
      if (countdownEl) countdownEl.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(timer);
        location.reload();
      }
    }, 1000);
  </script>
</body>

</html>
