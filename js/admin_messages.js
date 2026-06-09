document.addEventListener('DOMContentLoaded', () => {
  const page = document.getElementById('adminMessagesPage');
  const table = document.getElementById('adminMessagesTable');

  if (!page || !table) return;

  const endpoint = page.dataset.endpoint || window.location.href;
  const pageSize = parseInt(page.dataset.pageSize || '8', 10);
  const tbody = table.querySelector('tbody');
  const selectAll = document.getElementById('selectAllMsgs');
  const bulkBar = document.getElementById('bulkBar');
  const bulkCount = document.getElementById('bulkCount');
  const bulkMarkRead = document.getElementById('bulkMarkRead');
  const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
  const markAllReadBtn = document.getElementById('markAllReadBtn');
  const searchInput = document.getElementById('adminMsgSearch');
  const statusSelect = document.getElementById('adminMsgStatus');
  const dateInput = document.getElementById('adminMsgDate');
  const filterBtn = document.getElementById('adminMsgFilterBtn');
  const emptyState = document.getElementById('emptyState');
  const paginationInfo = document.getElementById('paginationInfo');
  const pagination = document.getElementById('messagesPagination');
  const unreadCount = document.getElementById('unreadCount');
  const totalMessagesCount = document.getElementById('totalMessagesCount');
  const modalEl = document.getElementById('messageModal');
  const modalDeleteBtn = document.getElementById('modalDeleteBtn');
  const msgModal = modalEl && window.bootstrap ? new bootstrap.Modal(modalEl) : null;
  let activeRow = null;
  let currentPage = 1;

  const rows = () => Array.from(tbody.querySelectorAll('tr.msg-row'));
  const visibleRows = () => rows().filter(row => !row.classList.contains('d-none'));
  const checkedRows = () => rows().filter(row => row.querySelector('.row-check')?.checked);

  function setSidebarActiveLink() {
    document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
      link.classList.toggle('active', link.getAttribute('href')?.endsWith('admin_messages.php'));
    });
  }

  function syncSidebarOverlayDisplay() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebarToggle || !sidebar || !overlay) return;

    const syncDisplay = () => {
      overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    };

    sidebarToggle.addEventListener('click', syncDisplay);
    overlay.addEventListener('click', syncDisplay);
  }

  async function requestAction(action, ids = []) {
    const form = new FormData();
    form.append('ajax_action', action);
    ids.forEach(id => form.append('ids[]', id));

    const response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: form,
    });

    let payload = {};
    try {
      payload = await response.json();
    } catch (error) {
      payload = {};
    }

    if (!response.ok || !payload.success) {
      throw new Error(payload.message || 'تعذر تنفيذ العملية الآن.');
    }

    return payload;
  }

  function updateCounts(counts) {
    const fallbackTotal = rows().length;
    const fallbackUnread = rows().filter(row => row.dataset.status === 'unread').length;
    const total = counts?.total ?? fallbackTotal;
    const unread = counts?.unread ?? fallbackUnread;

    if (totalMessagesCount) totalMessagesCount.textContent = total;
    if (unreadCount) unreadCount.textContent = unread;
    if (markAllReadBtn) markAllReadBtn.disabled = unread === 0;
    if (selectAll) selectAll.disabled = total === 0;
  }

  function matchesFilters(row) {
    const query = (searchInput?.value || '').trim().toLowerCase();
    const status = statusSelect?.value || '';
    const date = dateInput?.value || '';
    const content = [
      row.dataset.name,
      row.dataset.email,
      row.dataset.subject,
      row.dataset.body,
    ].join(' ').toLowerCase();

    const matchesQuery = !query || content.includes(query);
    const matchesStatus = !status || row.dataset.status === status;
    const matchesDate = !date || row.dataset.dateValue === date;

    return matchesQuery && matchesStatus && matchesDate;
  }

  function updateBulkBar() {
    const selected = checkedRows();
    const selectableRows = visibleRows();

    if (bulkCount) bulkCount.textContent = selected.length;
    if (bulkBar) bulkBar.style.display = selected.length > 0 ? 'flex' : 'none';
    if (deleteSelectedBtn) deleteSelectedBtn.style.display = selected.length > 0 ? '' : 'none';

    if (selectAll) {
      selectAll.indeterminate = selected.length > 0 && selected.length < selectableRows.length;
      selectAll.checked = selectableRows.length > 0 && selected.length === selectableRows.length;
    }
  }

  function renderPagination(totalRows) {
    if (!pagination) return;

    const pages = Math.max(1, Math.ceil(totalRows / pageSize));
    currentPage = Math.min(currentPage, pages);
    pagination.innerHTML = '';

    if (totalRows <= pageSize) return;

    const appendItem = (label, pageNumber, options = {}) => {
      const item = document.createElement('li');
      item.className = `page-item${options.disabled ? ' disabled' : ''}${options.active ? ' active' : ''}`;

      const link = document.createElement('a');
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
    };

    appendItem('<i class="bi bi-chevron-right"></i>', currentPage - 1, { disabled: currentPage === 1 });

    for (let pageNumber = 1; pageNumber <= pages; pageNumber += 1) {
      appendItem(String(pageNumber), pageNumber, { active: pageNumber === currentPage });
    }

    appendItem('<i class="bi bi-chevron-left"></i>', currentPage + 1, { disabled: currentPage === pages });
  }

  function applyList() {
    const allRows = rows();
    const filtered = allRows.filter(matchesFilters);
    const totalFiltered = filtered.length;
    const totalPages = Math.max(1, Math.ceil(totalFiltered / pageSize));

    currentPage = Math.min(currentPage, totalPages);

    const startIndex = (currentPage - 1) * pageSize;
    const endIndex = startIndex + pageSize;
    const pageRows = filtered.slice(startIndex, endIndex);

    allRows.forEach(row => {
      row.classList.add('d-none');
      const checkbox = row.querySelector('.row-check');
      if (checkbox) checkbox.checked = false;
    });

    pageRows.forEach(row => row.classList.remove('d-none'));

    if (emptyState) {
      emptyState.style.display = totalFiltered === 0 && allRows.length > 0 ? 'block' : 'none';
    }

    if (paginationInfo) {
      const from = totalFiltered === 0 ? 0 : startIndex + 1;
      const to = Math.min(endIndex, totalFiltered);
      paginationInfo.textContent = `عرض ${from} إلى ${to} من ${totalFiltered} رسالة`;
    }

    renderPagination(totalFiltered);
    updateBulkBar();
    updateCounts();
  }

  function applyReadState(row) {
    if (!row) return;

    row.classList.remove('row-unread');
    row.dataset.status = 'read';

    row.querySelector('.unread-dot')?.remove();
    row.querySelector('.msg-avatar')?.classList.add('read');
    row.querySelector('.sender-name')?.classList.add('read');

    const subject = row.querySelector('.subj-unread, .subj-read');
    if (subject) subject.className = 'subj-read';

    const badge = row.querySelector('.status-badge');
    if (badge) {
      badge.className = 'status-badge status-completed';
      badge.innerHTML = '<i class="bi bi-envelope-open" style="font-size:0.65rem;"></i> مقروءة';
    }

    row.querySelector('.btn-mark-read')?.remove();
  }

  async function markRowsRead(targetRows) {
    const unreadRows = targetRows.filter(row => row.dataset.status === 'unread');
    if (!unreadRows.length) return;

    try {
      const payload = await requestAction('mark_read', unreadRows.map(row => row.dataset.id));
      unreadRows.forEach(applyReadState);
      updateCounts(payload.counts);
      applyList();
    } catch (error) {
      alert(error.message);
    }
  }

  async function markAllRowsRead() {
    const unreadRows = rows().filter(row => row.dataset.status === 'unread');
    if (!unreadRows.length) return;

    try {
      const payload = await requestAction('mark_all_read');
      unreadRows.forEach(applyReadState);
      updateCounts(payload.counts);
      applyList();
    } catch (error) {
      alert(error.message);
    }
  }

  function removeRowsFromDom(targetRows) {
    targetRows.forEach(row => {
      row.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
      row.style.opacity = '0';
      row.style.transform = 'translateX(8px)';
      setTimeout(() => row.remove(), 250);
    });

    setTimeout(() => {
      applyList();
      updateCounts();
    }, 280);
  }

  async function deleteRows(targetRows) {
    if (!targetRows.length) return false;

    const message = targetRows.length === 1
      ? 'هل تريد حذف هذه الرسالة؟'
      : `هل تريد حذف ${targetRows.length} رسائل؟`;

    if (!window.confirm(message)) return false;

    try {
      const payload = await requestAction('delete', targetRows.map(row => row.dataset.id));
      updateCounts(payload.counts);
      removeRowsFromDom(targetRows);
      return true;
    } catch (error) {
      alert(error.message);
      return false;
    }
  }

  function openMessageModal(row) {
    activeRow = row;

    const name = row.dataset.name || '';
    const email = row.dataset.email || '';
    const subject = row.dataset.subject || '';

    document.getElementById('modalAvatar').textContent = Array.from(name.trim())[0] || '؟';
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('modalDate').textContent = row.dataset.date || '';
    document.getElementById('modalSubject').textContent = `الموضوع: ${subject}`;
    document.getElementById('modalBody').textContent = row.dataset.body || '';
    document.getElementById('modalReplyBtn').href = `mailto:${email}?subject=${encodeURIComponent(`رد: ${subject}`)}`;

    if (row.dataset.status === 'unread') {
      markRowsRead([row]);
    }

    if (msgModal) msgModal.show();
  }

  if (selectAll) {
    selectAll.addEventListener('change', () => {
      visibleRows().forEach(row => {
        const checkbox = row.querySelector('.row-check');
        if (checkbox) checkbox.checked = selectAll.checked;
      });
      updateBulkBar();
    });
  }

  tbody.addEventListener('change', event => {
    if (event.target.classList.contains('row-check')) {
      updateBulkBar();
    }
  });

  tbody.addEventListener('click', event => {
    const markButton = event.target.closest('.btn-mark-read');
    if (markButton) {
      event.stopPropagation();
      markRowsRead([markButton.closest('tr.msg-row')]);
      return;
    }

    const deleteButton = event.target.closest('.btn-delete-msg');
    if (deleteButton) {
      event.stopPropagation();
      deleteRows([deleteButton.closest('tr.msg-row')]);
      return;
    }

    if (event.target.closest('button, input, a, select, label')) return;

    const row = event.target.closest('tr.msg-row');
    if (row) openMessageModal(row);
  });

  if (bulkMarkRead) {
    bulkMarkRead.addEventListener('click', () => markRowsRead(checkedRows()));
  }

  if (deleteSelectedBtn) {
    deleteSelectedBtn.addEventListener('click', () => deleteRows(checkedRows()));
  }

  if (markAllReadBtn) {
    markAllReadBtn.addEventListener('click', markAllRowsRead);
  }

  if (modalDeleteBtn) {
    modalDeleteBtn.addEventListener('click', async () => {
      if (!activeRow) return;
      const deleted = await deleteRows([activeRow]);
      if (deleted && msgModal) msgModal.hide();
    });
  }

  if (filterBtn) {
    filterBtn.addEventListener('click', () => {
      currentPage = 1;
      applyList();
    });
  }

  [searchInput, statusSelect, dateInput].forEach(control => {
    if (!control) return;
    control.addEventListener('input', () => {
      currentPage = 1;
      applyList();
    });
    control.addEventListener('change', () => {
      currentPage = 1;
      applyList();
    });
  });

  if (pagination) {
    pagination.addEventListener('click', event => {
      const link = event.target.closest('a[data-page]');
      if (!link || link.closest('.disabled')) return;

      event.preventDefault();
      currentPage = parseInt(link.dataset.page, 10);
      applyList();
    });
  }

  setSidebarActiveLink();
  syncSidebarOverlayDisplay();
  applyList();
});
