<footer class="footer" id="footer">
    <div class="container">
        <div class="row g-4">
            <!-- Brand -->
            <div class="col-lg-6">
                <div class="footer-brand">
                    <i class="bi bi-bag-heart"></i>
                    متجر<span>نا</span>
                </div>
                <p class="footer-text">
                    متجرنا هو وجهتك الأولى للتسوق الإلكتروني. نوفر لك تجربة تسوق سهلة وممتعة مع أفضل المنتجات وأسرع خدمة شحن.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading">روابط سريعة</h6>
                <ul class="footer-links">
                    <li><a href="<?= APPURL ?>index.php">الرئيسية</a></li>
                    <li><a href="<?= APPURL ?>products.php">المنتجات</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="<?= APPURL ?>cart.php">سلة المشتريات</a></li>
                    <?php endif; ?>
                    <li><a href="<?= APPURL ?>contact.php">تواصل معنا</a></li>
                </ul>
            </div>


            <!-- Contact Info -->
            <div class="col-lg-4">
                <h6 class="footer-heading">تواصل معنا</h6>
                <ul class="footer-links">
                    <li>
                        <i class="bi bi-geo-alt ms-2 text-primary-custom"></i>
                        فلسطين غزة معسكر جباليا شارع الترنس
                    </li>
                    <li>
                        <i class="bi bi-telephone ms-2 text-primary-custom"></i>
                        <span dir="ltr">+970 59 362 8153</span>
                    </li>
                    <li>
                        <i class="bi bi-envelope ms-2 text-primary-custom"></i>
                        info@mohammedzomlot.dev
                    </li>
                </ul>
                <!-- Social Icons -->
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="nav-icon-btn" style="width:36px;height:36px;font-size:0.95rem;">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="nav-icon-btn" style="width:36px;height:36px;font-size:0.95rem;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="nav-icon-btn" style="width:36px;height:36px;font-size:0.95rem;">
                        <i class="bi bi-snapchat"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="mb-0">© 2026 متجرنا. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo APPURL . 'js/main.js?v=' . time(); ?>"></script>

</body>

</html>