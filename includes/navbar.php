<nav class="navbar navbar-expand-lg navbar-custom sticky-top" id="mainNavbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-bag-heart"></i>
            متجر<span>نا</span>
        </a>

        <!-- Toggler (Mobile) -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo APPURL; ?>index.php">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo APPURL; ?>products.php">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo APPURL; ?>contact.php">تواصل معنا</a>
                </li>
            </ul>

            <!-- Nav Actions -->
            <div class="nav-actions">


                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <ul class="navbar-nav ms-auto gap-1">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo APPURL; ?>auth/login.php">
                                <i class="bi bi-box-arrow-in-right"></i>
                                تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APPURL; ?>auth/register.php">
                                <i class="bi bi-person-plus"></i>
                                تسجيل حساب جديد
                            </a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav ms-auto gap-1">
                        <li class="nav-item">
                            <a href="<?php echo APPURL; ?>cart.php" class="nav-icon-btn" title="سلة المشتريات">
                                <i class="bi bi-bag"></i>
                                <span class="badge-dot"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo APPURL; ?>profile.php" class="nav-icon-btn" title="حسابي">
                                <i class="bi bi-person"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo APPURL; ?>auth/login.php">
                                <i class="bi bi-box-arrow-in-right"></i>
                                تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>