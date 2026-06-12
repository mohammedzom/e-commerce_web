document.addEventListener('DOMContentLoaded', function () {
    var rows = Array.prototype.slice.call(document.querySelectorAll('#adminUsersTable tbody tr'));
    var info = document.getElementById('adminUsersPaginationInfo');
    var pagination = document.getElementById('adminUsersPagination');
    var pageSize = 6;
    var currentPage = 1;

    if (!pagination || rows.length === 0) return;

    function appendItem(label, pageNumber, options) {
        options = options || {};
        var item = document.createElement('li');
        item.className = 'page-item' + (options.disabled ? ' disabled' : '') + (options.active ? ' active' : '');

        var link = document.createElement('a');
        link.className = 'page-link border-0 rounded-3';
        link.href = '#';
        link.dataset.page = String(pageNumber);
        link.innerHTML = label;

        if (options.active) {
            link.style.background = 'var(--color-primary)';
            link.style.borderColor = 'var(--color-primary)';
        } else {
            link.style.color = options.disabled ? 'var(--color-text-muted)' : 'var(--color-text-secondary)';
        }

        item.appendChild(link);
        pagination.appendChild(item);
    }

    function appendEllipsis() {
        var item = document.createElement('li');
        item.className = 'page-item disabled';

        var span = document.createElement('span');
        span.className = 'page-link border-0 rounded-3';
        span.style.color = 'var(--color-text-muted)';
        span.textContent = '...';

        item.appendChild(span);
        pagination.appendChild(item);
    }

    function renderPagination(totalPages) {
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        var maxVisible = 5;
        var startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        var endPage = Math.min(totalPages, startPage + maxVisible - 1);
        startPage = Math.max(1, endPage - maxVisible + 1);

        appendItem('<i class="bi bi-chevron-right"></i>', currentPage - 1, {
            disabled: currentPage === 1
        });

        if (startPage > 1) {
            appendItem('1', 1);
            if (startPage > 2) appendEllipsis();
        }

        for (var i = startPage; i <= endPage; i++) {
            appendItem(String(i), i, {
                active: i === currentPage
            });
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) appendEllipsis();
            appendItem(String(totalPages), totalPages);
        }

        appendItem('<i class="bi bi-chevron-left"></i>', currentPage + 1, {
            disabled: currentPage === totalPages
        });
    }

    function renderPage() {
        var totalItems = rows.length;
        var totalPages = Math.max(1, Math.ceil(totalItems / pageSize));
        currentPage = Math.min(currentPage, totalPages);

        var startIndex = (currentPage - 1) * pageSize;
        var endIndex = startIndex + pageSize;

        rows.forEach(function (row, index) {
            row.classList.toggle('d-none', index < startIndex || index >= endIndex);
        });

        if (info) {
            info.textContent = 'عرض ' + (totalItems === 0 ? 0 : startIndex + 1) + ' إلى ' + Math.min(endIndex, totalItems) + ' من ' + totalItems + ' مستخدم';
        }

        renderPagination(totalPages);
    }

    pagination.addEventListener('click', function (event) {
        var link = event.target.closest('a[data-page]');
        event.preventDefault();
        if (!link || link.closest('.disabled')) return;

        currentPage = parseInt(link.dataset.page, 10);
        renderPage();
    });

    renderPage();
});
