<?php
$page_description = "إنشاء حساب جديد في متجرنا — ابدأ رحلة تسوقك الآن.";
$page_title = "إنشاء حساب";
$error = "";
include "../includes/header.php";
require "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    $error = "الرجاء ملء جميع الحقول";
  } else {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $checkUser = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $checkUser->execute(['email' => $email]);

    if ($checkUser->rowCount() > 0) {
      $error = "هذا البريد الإلكتروني مستخدم بالفعل. قم بتسجيل الدخول";
    } else {

      $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $name = filter_var(trim($_POST['first_name'] . ' ' . $_POST['last_name']), FILTER_SANITIZE_SPECIAL_CHARS);
      $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
      $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_NUMBER_INT);
      $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_SPECIAL_CHARS);
      try {
        $register = $conn->prepare("INSERT INTO users (full_name, email, phone, address, password) VALUES (:full_name, :email, :phone, :address, :password)");
        $register->execute([
          'full_name' => $name,
          'email' => $email,
          'phone' => $phone,
          'address' => $address,
          'password' => $hashedPassword
        ]);
      } catch (PDOException $e) {
        $error = 'حدث خطأ ما';
      }

      $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
      $login->execute(['email' => $email]);
      $fetch = $login->fetch(PDO::FETCH_OBJ);

      $_SESSION['full_name'] = $fetch->full_name;
      $_SESSION['user_id']   = $fetch->user_id;
      $_SESSION['role']      = $fetch->role;

      header('Location: ' . APPURL);
    }
  }
}
?>

<body>

  <div class="auth-wrapper">
    <div class="auth-card animate-fadeInUp" style="max-width:480px;">
      <div class="auth-logo">
        <a href="index.php" style="color:inherit;">
          <h2><i class="bi bi-bag-heart"></i> متجر<span>نا</span></h2>
        </a>
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">أنشئ حسابك الجديد وابدأ التسوق</p>
      </div>

      <form id="registerForm" method="POST" action="register.php">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label-custom" for="regFirstName">الاسم الأول</label>
            <input type="text" class="form-control form-control-custom" id="regFirstName" placeholder="محمد" required name="first_name">
          </div>
          <div class="col-md-6">
            <label class="form-label-custom" for="regLastName">اسم العائلة</label>
            <input type="text" class="form-control form-control-custom" id="regLastName" placeholder="أحمد" required name="last_name">
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regEmail">البريد الإلكتروني</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-envelope"></i>
            </span>
            <input type="email" class="form-control form-control-custom" id="regEmail" placeholder="example@mail.com" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);" name="email">
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regPhone">رقم الجوال</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-phone"></i>
            </span>
            <input type="tel" class="form-control form-control-custom" id="regPhone" placeholder="05XXXXXXXX" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);" name="phone">
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label-custom" for="regPassword">كلمة المرور</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-lock"></i>
            </span>
            <input type="password" class="form-control form-control-custom" id="regPassword" placeholder="••••••••" required style="border-radius:0;" name="password">
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
            <input type="password" class="form-control form-control-custom" id="regConfirmPassword" placeholder="••••••••" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);" name="confirm_password">
          </div>
        </div>
        <p class="text-danger"> <?php echo $error; ?></p>

        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="agreeTerms" required name="terms">
          <label class="form-check-label" for="agreeTerms" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
            أوافق على <a href="<?php echo APPURL ?>terms.php">الشروط والأحكام</a> و<a href="<?php echo APPURL ?>privacy.php">سياسة الخصوصية</a>
          </label>
        </div>

        <button type="submit" class="btn btn-primary-custom w-100 mt-4" id="registerBtn">
          إنشاء الحساب
        </button>
      </form>

      <p class="text-center mb-0" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
        لديك حساب بالفعل؟ <a href="<?php echo APPURL; ?>auth/login.php" style="font-weight:600;">تسجيل الدخول</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL ?>js/main.js"></script>
</body>

</html>