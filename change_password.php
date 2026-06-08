<?php
$page_description = "تغيير كلمة المرور في متجرنا - حدّث كلمة مرور حسابك بسهولة.";
$page_title = "تغيير كلمة المرور - متجرنا";
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . "/includes/middleware/check-login.php";
include __DIR__ . "/includes/header.php";

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

$error = '';
$success = '';

if (isset($_POST['changePasswordForm'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($current_password, $user->password)) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) < 8) {
                $error = "كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = :password WHERE user_id = :user_id")
                    ->execute([':password' => $hashed_password, ':user_id' => $_SESSION['user_id']]);
                $success = 'تم تحديث كلمة المرور بنجاح';
            }
        } else {
            $error = 'كلمة المرور الجديدة وتأكيدها غير متطابقين';
        }
    } else {
        $error = 'كلمة المرور الحالية غير صحيحة';
    }
}
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-bag-heart"></i>
                متجر<span>نا</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">تواصل معنا</a>
                    </li>
                </ul>

                <div class="nav-actions">
                    <ul class="navbar-nav ms-auto gap-1">
                        <li class="nav-item">
                            <a href="cart.php" class="nav-icon-btn" title="سلة المشتريات">
                                <i class="bi bi-bag"></i>
                                <span class="badge-dot"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="profile.php" class="nav-icon-btn" title="حسابي">
                                <i class="bi bi-person"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="auth/logout.php">
                                <i class="bi bi-box-arrow-in-right"></i>
                                تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <div class="container">
            <h1>تغيير كلمة المرور</h1>
            <div class="breadcrumb-custom">
                <a href="index.php">الرئيسية</a>
                <span class="separator">/</span>
                <a href="profile.php">حسابي</a>
                <span class="separator">/</span>
                <span>تغيير كلمة المرور</span>
            </div>
        </div>
    </div>

    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="card-custom" style="padding:var(--space-xl);border-radius:var(--radius-xl);">
                        <div class="text-center mb-4">
                            <div class="profile-avatar mx-auto mb-3">
                                <?php echo $user->full_name[0]; ?>
                            </div>
                            <h5 style="font-weight:700;margin-bottom:2px;">
                                <?php echo $user->full_name; ?>
                            </h5>
                            <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">إدارة إعدادات الحساب</p>
                        </div>

                        <ul class="nav flex-column gap-1">
                            <li>
                                <a href="profile.php" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-person"></i>
                                    البيانات الشخصية
                                </a>
                            </li>
                            <li>
                                <a href="order_history.php" class="nav-link d-flex align-items-center gap-2" style="color:var(--color-text-secondary);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-bag"></i>
                                    سجل الطلبات
                                </a>
                            </li>
                            <li>
                                <a href="change_password.php" class="nav-link d-flex align-items-center gap-2 active" style="color:var(--color-primary);background:var(--color-primary-ultra-light);border-radius:var(--radius-md);padding:0.6rem 0.85rem;font-size:var(--font-size-sm);font-weight:500;">
                                    <i class="bi bi-lock"></i>
                                    تغيير كلمة المرور
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card-custom" style="padding:var(--space-2xl);border-radius:var(--radius-xl);">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                            <div>
                                <h5 style="font-weight:700;margin-bottom:var(--space-xs);">
                                    <i class="bi bi-shield-lock ms-2 text-primary-custom"></i>
                                    تحديث كلمة المرور
                                </h5>
                                <p class="text-muted-custom mb-0" style="font-size:var(--font-size-sm);">اختر كلمة مرور قوية ومختلفة عن كلمات المرور السابقة.</p>
                            </div>
                            <div class="status-badge status-processing">
                                <i class="bi bi-shield-check"></i>
                                حساب آمن
                            </div>
                        </div>

                        <?php if (!empty($success) || !empty($error)): ?>
                            <div class="d-flex align-items-start gap-3 mb-4 animate-fadeInUp" role="alert" style="padding:var(--space-md) var(--space-lg);border-radius:var(--radius-lg);border:1px solid <?php echo !empty($success) ? 'var(--color-success)' : 'var(--color-danger)'; ?>;background:<?php echo !empty($success) ? 'var(--color-success-light)' : 'var(--color-danger-light)'; ?>;">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;border-radius:var(--radius-md);background:var(--color-white);color:<?php echo !empty($success) ? 'var(--color-success)' : 'var(--color-danger)'; ?>;font-size:var(--font-size-lg);box-shadow:var(--shadow-xs);">
                                    <i class="bi <?php echo !empty($success) ? 'bi-check-circle-fill' : 'bi-x-circle-fill'; ?>"></i>
                                </div>
                                <div>
                                    <h6 style="font-weight:700;margin-bottom:2px;color:var(--color-text);">
                                        <?php echo !empty($success) ? 'تمت العملية بنجاح' : 'تعذرت العملية'; ?>
                                    </h6>
                                    <p class="mb-0" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                                        <?php echo htmlspecialchars(!empty($success) ? $success : $error, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="change_password.php">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-custom" for="currentPassword">كلمة المرور الحالية</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-custom" id="currentPassword" name="current_password" placeholder="أدخل كلمة المرور الحالية" required style="border-radius:0;">
                                        <button class="input-group-text toggle-password" type="button" aria-label="إظهار كلمة المرور" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom" for="newPassword">كلمة المرور الجديدة</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
                                            <i class="bi bi-key"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-custom" id="newPassword" name="new_password" placeholder="أدخل كلمة المرور الجديدة" required style="border-radius:0;">
                                        <button class="input-group-text toggle-password" type="button" aria-label="إظهار كلمة المرور" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-custom" for="confirmPassword">تأكيد كلمة المرور الجديدة</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="border:1.5px solid var(--color-border);border-left:0;border-radius:0 var(--radius-md) var(--radius-md) 0;background:var(--color-bg-alt);color:var(--color-text-muted);">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-custom" id="confirmPassword" name="confirm_password" placeholder="أعد إدخال كلمة المرور" required style="border-radius:0;">
                                        <button class="input-group-text toggle-password" type="button" aria-label="إظهار كلمة المرور" style="border:1.5px solid var(--color-border);border-right:0;border-radius:var(--radius-md) 0 0 var(--radius-md);background:var(--color-bg-alt);color:var(--color-text-muted);cursor:pointer;">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="p-3" style="background:var(--color-primary-ultra-light);border:1px solid var(--color-border-light);border-radius:var(--radius-lg);">
                                        <h6 style="font-size:var(--font-size-sm);font-weight:700;margin-bottom:var(--space-sm);">
                                            <i class="bi bi-info-circle ms-2 text-primary-custom"></i>
                                            نصائح لكلمة مرور قوية
                                        </h6>
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                                                    <i class="bi bi-check-circle-fill text-success-custom"></i>
                                                    8 أحرف على الأقل
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                                                    <i class="bi bi-check-circle-fill text-success-custom"></i>
                                                    حروف وأرقام
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2" style="font-size:var(--font-size-sm);color:var(--color-text-secondary);">
                                                    <i class="bi bi-check-circle-fill text-success-custom"></i>
                                                    رمز خاص واحد
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex flex-column flex-sm-row gap-2 justify-content-end mt-2">
                                    <a href="profile.php" class="btn btn-outline-custom">
                                        إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary-custom" name="changePasswordForm" value="1">
                                        <i class="bi bi-check-lg me-2"></i>
                                        حفظ كلمة المرور
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>