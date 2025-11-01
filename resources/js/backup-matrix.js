(function () {
  /* ---- Modal helpers ---- */
  const modal = document.getElementById('sltNoBackupModal');
  const closeBtn = document.getElementById('sltNoBackupClose');
  const cancelBtn = document.getElementById('sltNoBackupCancel');
  function openModal() {
    if (!modal) return;
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    cancelBtn?.focus();
  }
  function closeModal() {
    if (!modal) return;
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
  closeBtn?.addEventListener('click', closeModal);
  cancelBtn?.addEventListener('click', closeModal);
  modal?.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });

  /* ---- Click guard for non-admin users without backups ---- */
  const btn = document.getElementById('downloadBackupMatrix');
  if (btn) {
    const isAdmin = btn.getAttribute('data-is-admin') === '1';
    const hasBackup = btn.getAttribute('data-has-backup') === '1';
    btn.addEventListener('click', function (e) {
      if (!isAdmin && !hasBackup) {
        e.preventDefault();
        openModal();
      }
    });
  }
})();
