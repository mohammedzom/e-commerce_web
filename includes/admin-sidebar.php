<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <a href="<?= APPURL ?>index.php" style="color:inherit;text-decoration:none;">
            <i class="bi bi-bag-heart"></i> متجر<span>نا</span>
        </a>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-label">القائمة الرئيسية</li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_dashboard.php" class="nav-link"><i class="bi bi-grid-1x2"></i> لوحة التحكم</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_products.php" class="nav-link active"><i class="bi bi-box-seam"></i> المنتجات</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_orders.php" class="nav-link"><i class="bi bi-receipt"></i> الطلبات</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_users.php" class="nav-link"><i class="bi bi-people"></i> المستخدمين</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_messages.php" class="nav-link"><i class="bi bi-chat-dots"></i>الرسائل</a></li>
        <li class="nav-label" style="margin-top:var(--space-lg);">إعدادات</li>
        <li class="nav-item"><a href="<?= APPURL ?>admin_settings.php" class="nav-link"><i class="bi bi-gear"></i> إعدادات الموقع</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>index.php" class="nav-link"><i class="bi bi-house"></i> عرض الموقع</a></li>
        <li class="nav-item"><a href="<?= APPURL ?>auth/logout.php" class="nav-link" style="color:var(--color-danger);"><i class="bi bi-box-arrow-right"></i> تسجيل الخروج</a></li>
    </ul>
</aside>