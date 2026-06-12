/* ============================================
   E-Commerce — Main JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

  // ---- 1. Navbar Scroll Effect ----
  const navbar = document.querySelector('.navbar-custom');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 30) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }


  // ---- 2. Scroll Reveal Animations ----
  const revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length > 0) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-fadeInUp');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    revealElements.forEach(el => {
      el.style.opacity = '0';
      revealObserver.observe(el);
    });
  }


  // ---- 3. Quantity Controls ----
  document.querySelectorAll('.quantity-control').forEach(control => {
    const input = control.querySelector('input');
    const btnMinus = control.querySelector('.qty-minus');
    const btnPlus = control.querySelector('.qty-plus');

    if (!input) return;

    const checkLimits = () => {
      const val = parseInt(input.value) || 1;
      const min = parseInt(input.min) || 1;
      const max = parseInt(input.max) || Infinity;

      if (btnMinus) btnMinus.disabled = (val <= min);
      if (btnPlus) btnPlus.disabled = (val >= max);
    };

    if (btnMinus) {
      btnMinus.addEventListener('click', () => {
        const val = parseInt(input.value) || 1;
        const min = parseInt(input.min) || 1;
        if (val > min) {
          input.value = val - 1;
          checkLimits();
        }
      });
    }

    if (btnPlus) {
      btnPlus.addEventListener('click', () => {
        const val = parseInt(input.value) || 1;
        const max = parseInt(input.max) || Infinity;
        if (val < max) {
          input.value = val + 1;
          checkLimits();
        }
      });
    }

    input.addEventListener('input', () => {
        let val = parseInt(input.value);
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || Infinity;
        
        if (isNaN(val)) val = min;
        if (val < min) input.value = min;
        if (val > max) input.value = max;
        
        checkLimits();
    });

    // Initial check on load
    checkLimits();
  });


  // ---- 4. Admin Sidebar Toggle (Mobile) ----
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.querySelector('.admin-sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
      if (overlay) overlay.classList.toggle('show');
    });

    if (overlay) {
      overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
      });
    }
  }




  // ---- 6. Toggle Password Visibility ----
  document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.input-group').querySelector('input');
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });
  });


  // ---- 7. Active Nav Link ----
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.navbar-custom .nav-link, .sidebar-nav .nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage) {
      link.classList.add('active');
    }
  });

});
