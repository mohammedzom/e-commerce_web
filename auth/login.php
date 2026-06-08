<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../includes/header.php';

$error = '';

if (isset($_SESSION['user_id'])) {
  header('Location: ' . APPURL);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ip_address = $_SERVER['REMOTE_ADDR'];

  $check_attempts = $conn->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE ip_address = :ip");
  $check_attempts->execute(['ip' => $ip_address]);
  $attempt_data = $check_attempts->fetch(PDO::FETCH_OBJ);

  if ($attempt_data && $attempt_data->attempts >= 3) {
    $time_diff = time() - strtotime($attempt_data->last_attempt);
    if ($time_diff < 3600) {
      $error = 'لقد تجاوزت الحد المسموح من المحاولات. الرجاء المحاولة بعد ساعة.';
    } else {
      $conn->prepare("UPDATE login_attempts SET attempts = 0 WHERE ip_address = :ip")->execute(['ip' => $ip_address]);
      $attempt_data->attempts = 0;
    }
  }

  if (empty($error)) {
    if (empty($_POST['email']) or empty($_POST['password'])) {
      $error = 'الرجاء ملء جميع الحقول';
    } else {
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'الرجاء كتابة البريد الإلكتروني بشكل صحيح';
      } else {
        $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $login->execute(['email' => $email]);
        $fetch = $login->fetch(PDO::FETCH_OBJ);

        if ($login->rowCount() > 0 && password_verify($password, $fetch->password)) {
          $conn->prepare("DELETE FROM login_attempts WHERE ip_address = :ip")
          ->execute(['ip' => $ip_address]);

          $_SESSION['full_name'] = $fetch->full_name;
          $_SESSION['user_id']   = $fetch->user_id;
          $_SESSION['role']      = $fetch->role;

          if ($fetch->role == 'admin') {
              header('Location: ' . APPURL . 'admin_dashboard.php');
          } else {
              header('Location: ' . APPURL);
          }
          exit;
        } else {
          $error = 'البريد الإلكتروني أو كلمة المرور غير صحيحة';
          if ($attempt_data) {
            $conn->prepare("UPDATE login_attempts SET attempts = attempts + 1, last_attempt = CURRENT_TIMESTAMP WHERE ip_address = :ip")
            ->execute(['ip' => $ip_address]);
          } else {
            $conn->prepare("INSERT INTO login_attempts (ip_address, attempts) VALUES (:ip, 1)")
            ->execute(['ip' => $ip_address]);
          }
        }
      }
    }
  }
}

$page_description = "تسجيل الدخول إلى حسابك في متجرنا للوصول لطلباتك وتفاصيل حسابك.";
$page_title = "متجرنا — تسجيل الدخول";
?>

<body>

  <div class="auth-wrapper">
    <div class="auth-card animate-fadeInUp">
      <div class="auth-logo">
        <a href="<?php echo APPURL; ?>index.php" style="color:inherit;">
          <h2><i class="bi bi-bag-heart"></i> متجر<span>نا</span></h2>
        </a>
        <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">مرحباً بعودتك! سجّل دخولك للمتابعة</p>
      </div>

      <form id="loginForm" method="POST" action="login.php">
        <div class="mb-3">
          <label class="form-label-custom" for="loginEmail">البريد الإلكتروني</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-envelope"></i>
            </span>
            <input type="email" class="form-control form-control-custom" id="loginEmail" placeholder="example@mail.com" required style="border-radius:var(--radius-md) 0 0 var(--radius-md);" name="email">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label-custom" for="loginPassword">كلمة المرور</label>
          <div class="input-group">
            <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
              <i class="bi bi-lock"></i>
            </span>
            <input type="password" class="form-control form-control-custom" id="loginPassword" placeholder="••••••••" required style="border-radius:0;" name="password">
            <button class="input-group-text toggle-password" type="button" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
              <i class="bi bi-eye"></i>
            </button>
          </div>
          <p class="text-danger"> <?php echo $error; ?></p>
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
      <p class="text-center mb-0" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
        ليس لديك حساب؟ <a href="<?php echo APPURL; ?>auth/register.php" style="font-weight:600;">إنشاء حساب جديد</a>
      </p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo APPURL; ?>js/main.js"></script>
</body>

</html>
