// StayEase v3 — Mobile-first JS

// ── Modal ──
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

// ── Chip filter ──
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

// ── Saved contacts (Shopee-style) ──
let savedContacts = [
  { id: 1, name: 'Ceri Wijaya', email: 'ceri@email.com', phone: '+62 812-3456-7890', color: '#5B5FEF' },
  { id: 2, name: 'Mama', email: 'mama@gmail.com', phone: '+62 813-9876-5432', color: '#7C3AED' },
];

function renderContacts(targetForm) {
  const wrap = document.getElementById('contactList');
  if (!wrap) return;
  wrap.innerHTML = '';
  savedContacts.forEach(c => {
    const el = document.createElement('div');
    el.className = 'contact-item';
    el.dataset.id = c.id;
    el.innerHTML = `
      <div class="contact-av" style="background:${c.color}">${c.name[0]}</div>
      <div class="contact-info">
        <div class="contact-name">${c.name}</div>
        <div class="contact-detail">${c.email} · ${c.phone}</div>
      </div>
      <div class="contact-check" id="check-${c.id}">
        <svg width="12" height="12" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>`;
    el.addEventListener('click', () => selectContact(c));
    wrap.appendChild(el);
  });
}

function selectContact(c) {
  // Fill form fields
  const f = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
  f('guest_name', c.name);
  f('guest_email', c.email);
  f('guest_phone', c.phone);
  closeModal('contactModal');
  // Show saved badge
  const badge = document.getElementById('autofillBadge');
  if (badge) { badge.style.display = 'flex'; badge.querySelector('span').textContent = 'Data diisi dari: ' + c.name; }
}

function openAddContact() {
  const n = prompt('Nama lengkap:');
  if (!n) return;
  const e = prompt('Email:');
  const p = prompt('Nomor HP:');
  const colors = ['#5B5FEF','#7C3AED','#00C896','#FF4D6A','#FF9500'];
  savedContacts.push({ id: Date.now(), name: n, email: e||'', phone: p||'', color: colors[Math.floor(Math.random()*colors.length)] });
  renderContacts();
}

// ── Confetti ──
function spawnConfetti() {
  const wrap = document.getElementById('confettiWrap');
  if (!wrap) return;
  const cols = ['#5B5FEF','#7C3AED','#00C896','#FF4D6A','#FF9500','#60A5FA'];
  for (let i = 0; i < 70; i++) {
    const el = document.createElement('div');
    el.className = 'confetti-p';
    const sz = Math.random() * 8 + 5;
    el.style.cssText = `left:${Math.random()*100}%;width:${sz}px;height:${sz}px;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*2+1.5}s;animation-delay:${Math.random()*0.8}s;border-radius:${Math.random()>0.5?'50%':'3px'}`;
    wrap.appendChild(el);
  }
  setTimeout(() => { if (wrap) wrap.innerHTML = ''; }, 4500);
}

// ── Native-feel press states ──
document.addEventListener('touchstart', () => {}, { passive: true });
