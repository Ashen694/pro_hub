/* ========= Auto-fill "Work Plan Details" from selections ========= */
(function(){
  function getSelectedNames(scope){
    const wrapper = document.querySelector(`[data-dd="${scope}"]`);
    if(!wrapper) return [];
    const checks = wrapper.querySelectorAll('.slt-dd__panel input[type="checkbox"]:checked');
    return Array.from(checks).map(cb => (cb.getAttribute('data-name') || '').trim()).filter(Boolean);
  }

  function syncDetailsFromSelections(){
    const textarea = document.getElementById('details');
    if(!textarea) return;

    const selected = Array.from(new Set([
      ...getSelectedNames('ext'),
      ...getSelectedNames('int'),
    ]));

    let lines = textarea.value ? textarea.value.split(/\r?\n/) : [];

    const nameDashRe = /^\s*(.+?)\s*-\s*(.*)\s*$/;

    // Remove stale empty items (keep if user added a note)
    lines = lines.filter((line) => {
      const m = line.match(nameDashRe);
      if(!m) return true;
      const name = m[1].trim();
      const note = (m[2] ?? '').trim();
      if(!selected.includes(name) && note.length === 0){ return false; }
      return true;
    });

    // Track what still exists after prune
    const present = new Set();
    lines.forEach((line) => {
      const m = line.match(nameDashRe);
      if(m){ present.add(m[1].trim()); }
    });

    // Add new selected names
    selected.forEach((name) => {
      if(!present.has(name)){ lines.push(`${name} - `); }
    });

    textarea.value = lines.join('\n').replace(/\s+$/,'');
  }

  // Expose to dropdown logic
  window.sltSyncDetails = syncDetailsFromSelections;

  document.addEventListener('DOMContentLoaded', () => {
    syncDetailsFromSelections();
  });
})();

/* ========= Dropdown with checkbox logic ========= */
(function(){
  function wireDropdown(scope){
    const wrapper = document.querySelector(`[data-dd="${scope}"]`);
    if(!wrapper) return;
    const btn = wrapper.querySelector('.slt-dd__btn');
    const panel = wrapper.querySelector('.slt-dd__panel');
    const label = btn.querySelector('span');
    const checkboxes = panel.querySelectorAll('input[type="checkbox"]');

    function refreshLabel(){
      const chosen = Array.from(checkboxes).filter(c=>c.checked).map(c=>c.getAttribute('data-name'));
      if(chosen.length === 0){
        label.textContent = scope === 'ext' ? '— Select External —' : '— Select Internal —';
      }else if(chosen.length <= 2){
        label.textContent = chosen.join(', ');
      }else{
        label.textContent = chosen.slice(0,2).join(', ') + ` +${chosen.length-2} more`;
      }
    }

    btn.addEventListener('click', ()=>{
      const open = !panel.classList.contains('open');
      document.querySelectorAll('.slt-dd__panel').forEach(p=>p.classList.remove('open'));
      document.querySelectorAll('.slt-dd__btn').forEach(b=>b.setAttribute('aria-expanded','false'));
      if(open){ panel.classList.add('open'); btn.setAttribute('aria-expanded','true'); }
    });

    document.addEventListener('click', (e)=>{
      if(!wrapper.contains(e.target)){
        panel.classList.remove('open');
        btn.setAttribute('aria-expanded','false');
      }
    });

    document.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape'){
        panel.classList.remove('open');
        btn.setAttribute('aria-expanded','false');
      }
    });

    checkboxes.forEach(cb=>cb.addEventListener('change', ()=>{
      refreshLabel();
      if(window.sltSyncDetails) window.sltSyncDetails();
    }));

    // Initial label + details sync
    refreshLabel();
    if(window.sltSyncDetails) window.sltSyncDetails();
  }

  wireDropdown('ext');
  wireDropdown('int');
})();
