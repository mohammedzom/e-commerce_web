<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="تسجيل الدخول إلى حسابك في متجرنا للوصول لطلباتك وتفاصيل حسابك.">
  <title>متجرنا — تسجيل الدخول</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="auth-wrapper">
    <div class="auth-card animate-fadeInUp">
      <!-- Logo -->
      <div class="auth-logo">
        <a href="index.php" style="color:inherit;">
          <h2><i class="bi bi-bag-heart"></i> متجر<span>نا</span></h2>
        </a>
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">مرحباً بعودتك! سجّل دخولك للمتابعة</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm">
        <div class="mb-3">
          <label class="form-label-custom" for="loginEmail">البريد الإلكتروني</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-envelope"></i>
            </span>
            <input type="email" class="form-control form-control-custom" id="loginEmail" placeholder="example@mail.com" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label-custom" for="loginPassword">كلمة المرور</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-lock"></i>
            </span>
            <input type="password" class="form-control form-control-custom" id="loginPassword" placeholder="••••••••" required style="border-radius:0;">
            <button class="input-group-text toggle-password" type="button" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label" for="rememberMe" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
              تذكرني
            </label>
          </div>
          <a href="#" style="font-size:var(--font-size-sm);">نسيت كلمة المرور؟</a>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mb-3" id="loginBtn">
          تسجيل الدخول
        </button>
      </form>

      <div class="auth-divider">أو</div>

      <!-- Social Login -->
      <div class="d-flex gap-2 mb-4">
        <button class="btn btn-outline-custom flex-fill" style="font-size:var(--font-size-sm);">
          <i class="bi bi-google me-2"></i>Google
        </button>
        <button class="btn btn-outline-custom flex-fill" style="font-size:var(--font-size-sm);">
          <i class="bi bi-twitter-x me-2"></i>Twitter
        </button>
      </div>

      <!-- Register Link -->
      <p class="text-center mb-0" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
        ليس لديك حساب؟ <a href="register.php" style="font-weight:600;">إنشاء حساب جديد</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
