/* ===== Simple column sort for the report table ===== */
(function () {
  const table = document.getElementById('reportTable');
  if (!table) return;

  const thead = table.querySelector('thead');
  const tbody = table.querySelector('tbody');
  let asc = true;

  const getCell = (tr, idx) => (tr.children[idx]?.textContent || '').trim().toLowerCase();

  function sortBy(idx) {
    const rows = [...tbody.querySelectorAll('tr')].filter(r => !r.querySelector('.slt-empty'));
    rows.sort((a, b) => {
      const A = getCell(a, idx);
      const B = getCell(b, idx);
      return asc ? A.localeCompare(B) : B.localeCompare(A);
    });
    asc = !asc;
    rows.forEach(r => tbody.appendChild(r));
  }

  [...thead.querySelectorAll('th')].forEach((th, idx) => {
    th.addEventListener('click', () => sortBy(idx));
  });
})();
