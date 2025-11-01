/* ========= Auto-fill "Work Plan Details" from selections ========= */
(function(){
  function getSelectedNames(scope){
    const root = document.querySelector(`[data-multi="${scope}"]`);
    if(!root) return [];
    const checks = root.querySelectorAll('.slt-panel input[type="checkbox"].slt-check:checked');
    return Array.from(checks).map(cb => (cb.getAttribute('data-name') || '').trim()).filter(Boolean);
  }

  function syncDetailsFromSelections(){
    const textarea = document.getElementById('details');
    if(!textarea) return;

    const selected = Array.from(new Set([
      ...getSelectedNames('external'),
      ...getSelectedNames('internal'),
    ]));

    let lines = textarea.value ? textarea.value.split(/\r?\n/) : [];
    const nameDashRe = /^\s*(.+?)\s*-\s*(.*)\s*$/;

    // Remove empty placeholders for items no longer selected
    lines = lines.filter((line) => {
      const m = line.match(nameDashRe);
      if(!m) return true;
      const name = m[1].trim();
      const note = (m[2] ?? '').trim();
      if(!selected.includes(name) && note.length === 0){ return false; }
      return true;
    });

    // Accumulate existing names
    const existing = new Set();
    lines.forEach(l => { const m=l.match(nameDashRe); if(m) existing.add(m[1].trim()); });

    // Add missing placeholders
    selected.forEach((name) => {
      if(!existing.has(name)){ lines.push(`${name} - `); }
    });

    textarea.value = lines.join('\n').replace(/\s+$/,'');
  }

  window.sltSyncDetails = syncDetailsFromSelections;
  document.addEventListener('DOMContentLoaded', () => { syncDetailsFromSelections(); });
})();

/* ========= Multi-select dropdown logic ========= */
(function(){
  function setupMulti(root){
    const btn = root.querySelector('.slt-multi-btn');
    const panel = root.querySelector('.slt-panel');
    const labelEl = btn.querySelector('[data-label]');
    const scope = root.getAttribute('data-multi'); // 'external' | 'internal'

    function refreshLabel(){
      const checked = [...panel.querySelectorAll('.slt-check:checked')];
      const names = checked.map(el => el.getAttribute('data-name'));
      if(names.length === 0){
        labelEl.textContent = scope === 'external' ? '— Select External —' : '— Select Internal —';
      }else if(names.length <= 2){
        labelEl.textContent = names.join(', ');
      }else{
        labelEl.textContent = `${names.slice(0,2).join(', ')} +${names.length-2} more`;
      }
    }

    btn.addEventListener('click', ()=>{
      const willOpen = !panel.classList.contains('open');
      document.querySelectorAll('.slt-panel').forEach(p => p.classList.remove('open'));
      document.querySelectorAll('.slt-multi-btn').forEach(b => b.setAttribute('aria-expanded','false'));
      if(willOpen){ panel.classList.add('open'); btn.setAttribute('aria-expanded','true'); }
    });

    document.addEventListener('click', (e)=>{
      if(!root.contains(e.target)){ panel.classList.remove('open'); btn.setAttribute('aria-expanded','false'); }
    });

    panel.addEventListener('change', ()=>{
      refreshLabel();
      if(window.sltSyncDetails) window.sltSyncDetails();
    });

    // Initial state (respect old()/pre-checked)
    refreshLabel();
    if(window.sltSyncDetails) window.sltSyncDetails();
  }

  const extRoot = document.querySelector('[data-multi="external"]');
  if(extRoot) setupMulti(extRoot);

  const intRoot = document.querySelector('[data-multi="internal"]');
  if(intRoot) setupMulti(intRoot);
})();
