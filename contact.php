<?php

$page_title = 'متجرنا — تواصل معنا';
$page_description = 'تواصل معنا — نسعد بخدمتك. أرسل لنا رسالتك أو تواصل معنا مباشرة.';
include 'includes/header.php';
require_once 'config/config.php';


?>

<body>
  <?php include 'includes/navbar.php'; ?>
  <!-- PAGE HEADER -->
  <div class="page-header">
    <div class="container">
      <h1>تواصل معنا</h1>
      <div class="breadcrumb-custom">
        <a href="index.php">الرئيسية</a>
        <span class="separator">/</span>
        <span>تواصل معنا</span>
      </div>
    </div>
  </div>

  <section class="section-padding">
    <div class="container">
      <div class="row g-5">
        <!-- Contact Form -->
        <div class="col-lg-7">
          <div class="card-custom" style="border-radius:var(--radius-xl);padding:var(--space-2xl);">
            <h4 style="font-weight:700;margin-bottom:var(--space-sm);">أرسل لنا رسالة</h4>
            <p class="text-muted-custom mb-4" style="font-size:var(--font-size-sm);">يسعدنا سماع ملاحظاتك واستفساراتك. سنرد عليك في أقرب وقت ممكن.</p>

            <form id="contactForm" action="includes/handlers/contact-handler.php" method="post">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label-custom" for="contactName">الاسم الكامل</label>
                  <input type="text" class="form-control form-control-custom" id="contactName" name="name" placeholder="أدخل اسمك" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label-custom" for="contactEmail">البريد الإلكتروني</label>
                  <input type="email" class="form-control form-control-custom" id="contactEmail" name="email" placeholder="example@mail.com" required>
                </div>
                <div class="col-12">
                  <label class="form-label-custom" for="contactSubject">الموضوع</label>
                  <input type="text" class="form-control form-control-custom" id="contactSubject" name="subject" placeholder="موضوع الرسالة">
                </div>
                <div class="col-12">
                  <label class="form-label-custom" for="contactMessage">الرسالة</label>
                  <textarea class="form-control form-control-custom" id="contactMessage" name="message" rows="6" placeholder="اكتب رسالتك هنا ..." required></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary-custom px-4" id="sendMessageBtn" name="send">
                    <i class="bi bi-send me-2"></i>
                    إرسال الرسالة
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-5">
          <div class="contact-info-card">
            <div class="contact-icon">
              <i class="bi bi-geo-alt"></i>
            </div>
            <div>
              <h6>العنوان</h6>
              <p>الرياض، المملكة العربية السعودية<br>حي العليا، شارع الملك فهد</p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="contact-icon">
              <i class="bi bi-telephone"></i>
            </div>
            <div>
              <h6>الهاتف</h6>
              <p dir="ltr" style="text-align:right;">+966 50 000 0000<br>+966 11 000 0000</p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="contact-icon">
              <i class="bi bi-envelope"></i>
            </div>
            <div>
              <h6>البريد الإلكتروني</h6>
              <p>info@matjarna.com<br>support@matjarna.com</p>
            </div>
          </div>

          <div class="contact-info-card">
            <div class="contact-icon">
              <i class="bi bi-clock"></i>
            </div>
            <div>
              <h6>ساعات العمل</h6>
              <p>الأحد - الخميس: 9 صباحاً - 6 مساءً<br>الجمعة والسبت: مغلق</p>
            </div>
          </div>

          <!-- Social -->
          <div class="mt-4">
            <h6 style="font-weight:600;font-size:var(--font-size-sm);margin-bottom:var(--space-md);">تابعنا على</h6>
            <div class="d-flex gap-2">
              <a href="#" class="nav-icon-btn" style="width:42px;height:42px;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                <i class="bi bi-twitter-x"></i>
              </a>
              <a href="#" class="nav-icon-btn" style="width:42px;height:42px;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="nav-icon-btn" style="width:42px;height:42px;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                <i class="bi bi-snapchat"></i>
              </a>
              <a href="#" class="nav-icon-btn" style="width:42px;height:42px;background:var(--color-bg-alt);border-radius:var(--radius-md);">
                <i class="bi bi-whatsapp"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>