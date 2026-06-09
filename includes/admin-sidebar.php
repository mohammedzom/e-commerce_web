<?php

$cur_page = basename($_SERVER['PHP_SELF']);
$is_active = function ($page) use ($cur_page) {
    return $page === $cur_page ? 'active' : '';
};
?>

<div class="admin-wrapper">
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:999;"></div>


    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <a href="<?= APPURL ?>index.php" style="color:inherit;text-decoration:none;">
                <i class="bi bi-bag-heart"></i> متجر<span>نا</span>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="nav-label">القائمة الرئيسية</li>
            <li class="nav-item"><a href="<?= APPURL ?>admin_dashboard.php" class="nav-link <?= $is_active('admin_dashboard.php'); ?>"><i class="bi bi-grid-1x2"></i> لوحة التحكم</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>admin_products.php" class="nav-link <?= $is_active('admin_products.php'); ?>"><i class="bi bi-box-seam"></i> المنتجات</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>admin_orders.php" class="nav-link <?= $is_active('admin_orders.php'); ?>"><i class="bi bi-receipt"></i> الطلبات</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>admin_users.php" class="nav-link <?= $is_active('admin_users.php'); ?>"><i class="bi bi-people"></i> المستخدمين</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>admin_messages.php" class="nav-link <?= $is_active('admin_messages.php'); ?>"><i class="bi bi-chat-dots"></i>الرسائل</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>index.php" class="nav-link <?= $is_active('index.php'); ?>"><i class="bi bi-house"></i> عرض الموقع</a></li>
            <li class="nav-item"><a href="<?= APPURL ?>auth/logout.php" class="nav-link" style="color:var(--color-danger);"><i class="bi bi-box-arrow-right"></i> تسجيل الخروج</a></li>
        </ul>
    </aside>