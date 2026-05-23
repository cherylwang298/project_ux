function toggleModal(id) {
  const m = document.getElementById(id);
  if (!m) return;
  m.classList.toggle('open');
  document.body.style.overflow = m.classList.contains('open') ? 'hidden' : '';
}
function closeModal(id) {
  const m = document.getElementById(id);
  if (m) { m.classList.remove('open'); document.body.style.overflow = ''; }
}

// ── Tab switcher (hotel/flight/activity on homepage) ──
function switchTab(tab) {
  document.querySelectorAll('.booking-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
  document.querySelector('[data-tab="'+tab+'"]').classList.add('active');
  const content = document.getElementById('tab-'+tab);
  if (content) content.style.display = 'flex';
}

// ── Payment select ──
function selectPayment(el) {
  document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
  el.classList.add('selected');
  const r = el.querySelector('input[type="radio"]');
  if (r) r.checked = true;
}

// ── Filter sheet ──
function toggleFilterSheet() {
  const s = document.getElementById('filterSheet');
  if (s) s.classList.toggle('open');
}

// ── Chip select ──
function chipSelect(el) {
  el.closest('.filter-chips').querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
}

// ── Upsell toggle ──
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.upsell-item').forEach(item => {
    const cb = item.querySelector('input[type="checkbox"]');
    if (!cb) return;
    item.addEventListener('click', e => {
      if (e.target === cb) return;
      cb.checked = !cb.checked;
      item.classList.toggle('checked', cb.checked);
      if (typeof updateTotals === 'function') updateTotals();
    });
    cb.addEventListener('change', () => {
      item.classList.toggle('checked', cb.checked);
      if (typeof updateTotals === 'function') updateTotals();
    });
  });
});

// ── Contacts ──
function selectContactJS(c) {
  const f = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
  f('guest_name', c.name);
  f('guest_email', c.email);
  f('guest_phone', c.phone);
  closeModal('contactModal');
  const badge = document.getElementById('autofillBadge');
  if (badge) { badge.style.display = 'flex'; badge.querySelector('span').textContent = 'Data diisi dari: ' + c.name; }
}
function openContactPicker() { toggleModal('contactModal'); }
function showAddForm() {
  const f = document.getElementById('addContactForm');
  f.style.display = f.style.display === 'none' ? 'block' : 'none';
}

// ── Confetti ──
function spawnConfetti() {
  const wrap = document.getElementById('confettiWrap');
  if (!wrap) return;
  const cols = ['#A8D8C8','#B8CCEF','#C7B8EA','#F0C4D4','#B5E2D8','#E8C47A'];
  for (let i = 0; i < 75; i++) {
    const el = document.createElement('div');
    el.className = 'confetti-p';
    const sz = Math.random() * 8 + 5;
    el.style.cssText = `left:${Math.random()*100}%;width:${sz}px;height:${sz}px;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*2+1.5}s;animation-delay:${Math.random()*0.8}s;border-radius:${Math.random()>0.5?'50%':'3px'}`;
    wrap.appendChild(el);
  }
  setTimeout(() => { if (wrap) wrap.innerHTML = ''; }, 4500);
}

// ── Filter orders ──
function filterOrders(s, btn) {
  document.querySelectorAll('.filter-chips .chip').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.order-card').forEach(c => {
    c.style.display = (s === 'all' || c.dataset.status === s) ? 'block' : 'none';
  });
}

// ── Native-feel press ──
document.addEventListener('touchstart', () => {}, { passive: true });