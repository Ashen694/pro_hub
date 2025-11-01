// resources/js/weekly-index.js

document.addEventListener('DOMContentLoaded', () => {
  /* ---------- Details modal ---------- */
  const detailsBackdrop=document.getElementById('sltModalBackdrop');
  function fillDetails(btn){
    const set = (id, val) => { const el = document.getElementById(id); if(el) el.textContent = val || '—'; };
    set('sltModalWeek', btn.dataset.week);
    set('sltModalExternal', btn.dataset.external);
    set('sltModalInternal', btn.dataset.internal);
    set('sltModalDetails', btn.dataset.details);
    set('sltModalUpdatedBy', btn.dataset.updatedBy);
    set('sltModalUpdatedAt', btn.dataset.updatedAt);
  }
  function openSltModal(btn){
    if(!detailsBackdrop) return;
    fillDetails(btn);
    detailsBackdrop.style.display='flex';
    document.body.style.overflow='hidden';
  }
  function closeSltModal(){
    if(!detailsBackdrop) return;
    detailsBackdrop.style.display='none';
    document.body.style.overflow='';
  }
  window.closeSltModal = closeSltModal;

  document.addEventListener('click',e=>{
    const d=e.target.closest('.slt-details-btn');
    if(d) openSltModal(d);
  });
  if(detailsBackdrop){
    detailsBackdrop.addEventListener('click',e=>{ if(e.target===detailsBackdrop) closeSltModal(); });
  }
  document.addEventListener('keydown',e=>{ if(e.key==='Escape' && detailsBackdrop && detailsBackdrop.style.display==='flex') closeSltModal(); });

  /* ---------- Delete modal ---------- */
  const deleteBackdrop=document.getElementById('sltDeleteBackdrop');
  const delWeek=document.getElementById('delWeek');
  const delExternal=document.getElementById('delExternal');
  const delInternal=document.getElementById('delInternal');
  const delDetails=document.getElementById('delDetails');
  const delUpdatedBy=document.getElementById('delUpdatedBy');
  const delUpdatedAt=document.getElementById('delUpdatedAt');
  const confirmDeleteBtn=document.getElementById('sltConfirmDeleteBtn');
  let deleteFormRef=null;

  function openDeleteModal(formEl, payload){
    deleteFormRef=formEl;
    delWeek.textContent = payload.week || '—';
    delExternal.textContent = payload.external || '—';
    delInternal.textContent = payload.internal || '—';
    delDetails.textContent = payload.details || '—';
    delUpdatedBy.textContent = payload.updatedBy || '—';
    delUpdatedAt.textContent = payload.updatedAt || '—';
    if(deleteBackdrop){
      deleteBackdrop.style.display='flex';
      document.body.style.overflow='hidden';
    }
  }
  function closeDeleteModal(){
    if(deleteBackdrop){
      deleteBackdrop.style.display='none';
      document.body.style.overflow='';
    }
    deleteFormRef=null;
  }
  window.closeDeleteModal = closeDeleteModal;

  document.addEventListener('click',e=>{
    const btn=e.target.closest('.slt-delete-btn');
    if(!btn) return;
    const form=btn.closest('.slt-delete-form');
    openDeleteModal(form, {
      week: btn.dataset.week,
      external: btn.dataset.external,
      internal: btn.dataset.internal,
      details: btn.dataset.details,
      updatedBy: btn.dataset.updatedBy,
      updatedAt: btn.dataset.updatedAt,
    });
  });

  if(confirmDeleteBtn){
    confirmDeleteBtn.addEventListener('click',()=>{ if(deleteFormRef){ deleteFormRef.submit(); } });
  }
  if(deleteBackdrop){
    deleteBackdrop.addEventListener('click',e=>{ if(e.target===deleteBackdrop) closeDeleteModal(); });
  }
  document.addEventListener('keydown',e=>{ if(e.key==='Escape' && deleteBackdrop && deleteBackdrop.style.display==='flex') closeDeleteModal(); });

  /* ---------- Click-to-sort ---------- */
  (function(){
    const table=document.getElementById('weeklyTable');
    if(!table) return;
    const thead=table.tHead;
    const tbody=table.tBodies[0];
    let lastSorted=null;

    function parseWeekCell(txt){
      const m=txt.trim().match(/^(\d{2})\/(\d{2})\/(\d{4})/);
      if(!m) return 0;
      return new Date(+m[3], +m[2]-1, +m[1]).getTime();
    }

    function getCellValue(tr, idx, type){
      const text=(tr.children[idx]?.textContent||'').trim().toLowerCase();
      if(type==='date') return parseWeekCell(text);
      return text;
    }

    function sortBy(index, type){
      const dir = (lastSorted && lastSorted.index===index && lastSorted.dir==='asc') ? 'desc' : 'asc';
      lastSorted = {index, dir};

      const rows=[...tbody.rows];
      rows.sort((a,b)=>{
        const va=getCellValue(a,index,type);
        const vb=getCellValue(b,index,type);
        if(type==='date'){ return dir==='asc' ? (va - vb) : (vb - va); }
        if(va<vb) return dir==='asc'?-1:1;
        if(va>vb) return dir==='asc'?1:-1;
        return 0;
      });

      const frag=document.createDocumentFragment();
      rows.forEach(r=>frag.appendChild(r));
      tbody.appendChild(frag);
    }

    if(thead){
      thead.addEventListener('click',(e)=>{
        const th=e.target.closest('.slt-sortable');
        if(!th) return;
        sortBy(parseInt(th.dataset.col,10), th.dataset.type||'text');
      });
    }
  })();

  /* ---------- Particle background (same as other pages) ---------- */
  (function(){
    const canvas = document.getElementById('particleCanvas');
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(!canvas || prefersReduced) return;

    const ctx = canvas.getContext('2d');
    const wrap = document.querySelector('.slt-bg-wrap');

    function resize(){
      canvas.width = window.innerWidth;
      canvas.height = wrap ? wrap.offsetHeight : window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize, { passive:true });

    const colors = ['#2258a7','#46b6ef','#5fb545'];

    class P{
      constructor(){
        this.x=Math.random()*canvas.width; this.y=Math.random()*canvas.height;
        this.vx=(Math.random()-.5)*.5; this.vy=(Math.random()-.5)*.5;
        this.r=Math.random()*2.5+1.5; this.c=colors[(Math.random()*colors.length)|0];
        this.a=Math.random()*.5+.5;
      }
      u(){ this.x+=this.vx; this.y+=this.vy; if(this.x<0||this.x>canvas.width) this.vx*=-1; if(this.y<0||this.y>canvas.height) this.vy*=-1; }
      d(){ ctx.beginPath(); ctx.arc(this.x,this.y,this.r,0,Math.PI*2); ctx.fillStyle=this.c; ctx.globalAlpha=this.a; ctx.fill(); ctx.globalAlpha=1; }
    }

    const n = window.innerWidth < 768 ? 60 : 120;
    const ps = Array.from({length:n},()=>new P());

    function lines(){
      const m=180;
      for(let i=0;i<ps.length;i++){
        for(let j=i+1;j<ps.length;j++){
          const dx=ps[i].x-ps[j].x, dy=ps[i].y-ps[j].y, dist=Math.hypot(dx,dy);
          if(dist<m){
            const o=(1-dist/m)*.5;
            ctx.beginPath(); ctx.strokeStyle=`rgba(200,200,200,${o})`;
            ctx.lineWidth=1; ctx.moveTo(ps[i].x,ps[i].y); ctx.lineTo(ps[j].x,ps[j].y); ctx.stroke();
          }
        }
      }
    }

    (function anim(){
      ctx.clearRect(0,0,canvas.width,canvas.height);
      ps.forEach(p=>{p.u(); p.d();});
      lines();
      requestAnimationFrame(anim);
    })();
  })();
});
