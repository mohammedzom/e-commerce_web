<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="إنشاء حساب جديد في متجرنا — ابدأ رحلة تسوقك الآن.">
  <title>متجرنا — إنشاء حساب</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="auth-wrapper">
    <div class="auth-card animate-fadeInUp" style="max-width:480px;">
      <!-- Logo -->
      <div class="auth-logo">
        <a href="index.php" style="color:inherit;">
          <h2><i class="bi bi-bag-heart"></i> متجر<span>نا</span></h2>
        </a>
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">أنشئ حسابك الجديد وابدأ التسوق</p>
      </div>

      <!-- Register Form -->
      <form id="registerForm">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label-custom" for="regFirstName">الاسم الأول</label>
            <input type="text" class="form-control form-control-custom" id="regFirstName" placeholder="محمد" required>
          </div>
          <div class="col-md-6">
            <label class="form-label-custom" for="regLastName">اسم العائلة</label>
            <input type="text" class="form-control form-control-custom" id="regLastName" placeholder="أحمد" required>
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regEmail">البريد الإلكتروني</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-envelope"></i>
            </span>
            <input type="email" class="form-control form-control-custom" id="regEmail" placeholder="example@mail.com" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);">
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regPhone">رقم الجوال</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-phone"></i>
            </span>
            <input type="tel" class="form-control form-control-custom" id="regPhone" placeholder="05XXXXXXXX" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);">
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regPassword">كلمة المرور</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-lock"></i>
            </span>
            <input type="password" class="form-control form-control-custom" id="regPassword" placeholder="••••••••" required style="border-radius:0;">
            <button class="input-group-text toggle-password" type="button" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regConfirmPassword">تأكيد كلمة المرور</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" class="form-control form-control-custom" id="regConfirmPassword" placeholder="••••••••" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);">
          </div>
        </div>

        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="agreeTerms" required>
          <label class="form-check-label" for="agreeTerms" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
            أوافق على <a href="#">الشروط والأحكام</a> و<a href="#">سياسة الخصوصية</a>
          </label>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mt-4" id="registerBtn">
          إنشاء الحساب
        </button>
      </form>

      <div class="auth-divider">أو</div>

      <!-- Social Register -->
      <div class="d-flex gap-2 mb-4">
        <button class="btn btn-outline-custom flex-fill" style="font-size:var(--font-size-sm);">
          <i class="bi bi-google me-2"></i>Google
        </button>
        <button class="btn btn-outline-custom flex-fill" style="font-size:var(--font-size-sm);">
          <i class="bi bi-twitter-x me-2"></i>Twitter
        </button>
      </div>

      <!-- Login Link -->
      <p class="text-center mb-0" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
        لديك حساب بالفعل؟ <a href="login.php" style="font-weight:600;">تسجيل الدخول</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
