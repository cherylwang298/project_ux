// ============================================
// AGODA CLONE — app.js
// All JavaScript functions
// ============================================

// ── Modal functions ──
function toggleModal(id) {
  const m = document.getElementById(id);
  if (!m) return;
  m.classList.toggle('open');
  document.body.style.overflow = m.classList.contains('open') ? 'hidden' : '';
}

function closeModal(id) {
  const m = document.getElementById(id);
  if (m) { 
    m.classList.remove('open'); 
    document.body.style.overflow = ''; 
  }
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
  const chips = el.closest('.filter-chips');
  if (chips) {
    chips.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  }
  el.classList.add('active');
}

// ── Upsell toggle ──
function initUpsells() {
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
}

// ── Contacts ──
function selectContactJS(c) {
  const f = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
  f('guest_name', c.name);
  f('guest_email', c.email);
  f('guest_phone', c.phone);
  closeModal('contactModal');
  const badge = document.getElementById('autofillBadge');
  if (badge) { 
    badge.style.display = 'flex'; 
    const span = badge.querySelector('span');
    if (span) span.textContent = 'Data diisi dari: ' + c.name;
  }
}

function openContactPicker() { 
  toggleModal('contactModal'); 
}

function showAddForm() {
  const f = document.getElementById('addContactForm');
  if (f) f.style.display = f.style.display === 'none' ? 'block' : 'none';
}

// ── Confetti ──
function spawnConfetti() {
  const wrap = document.getElementById('confettiWrap');
  if (!wrap) return;
  const cols = ['#E2196F','#FF6B35','#00B87A','#FF9800','#0288D1','#FFF'];
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

// ── Date validation functions ──
function setMinDates() {
  const today = new Date().toISOString().split('T')[0];
  
  const checkinInputs = document.querySelectorAll('input[name="checkin"], input[name="dep_date"], input[name="date"]');
  checkinInputs.forEach(input => {
    input.setAttribute('min', today);
    input.addEventListener('change', function() {
      validateCheckinDate(this);
    });
    if (input.value && input.value < today) {
      input.value = today;
    }
  });
  
  const checkoutInputs = document.querySelectorAll('input[name="checkout"]');
  checkoutInputs.forEach(input => {
    input.addEventListener('change', function() {
      validateCheckoutDate(this);
    });
  });
  
  const checkinInput = document.querySelector('input[name="checkin"]');
  const checkoutInput = document.querySelector('input[name="checkout"]');
  if (checkinInput && checkoutInput) {
    updateCheckoutMinDate(checkinInput.value, checkoutInput);
  }
}

function validateCheckinDate(input) {
  const today = new Date().toISOString().split('T')[0];
  if (input.value < today) {
    input.value = today;
    showDateError(input, 'Tidak bisa memilih tanggal sebelum hari ini');
  } else {
    hideDateError(input);
  }
  
  const checkoutInput = document.querySelector('input[name="checkout"]');
  if (checkoutInput) {
    updateCheckoutMinDate(input.value, checkoutInput);
  }
}

function validateCheckoutDate(input) {
  const checkinInput = document.querySelector('input[name="checkin"]');
  if (checkinInput) {
    const checkinDate = new Date(checkinInput.value);
    const checkoutDate = new Date(input.value);
    const minCheckoutDate = new Date(checkinDate);
    minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
    
    if (checkoutDate <= checkinDate) {
      input.value = minCheckoutDate.toISOString().split('T')[0];
      showDateError(input, 'Check-out harus minimal 1 hari setelah check-in');
    } else {
      hideDateError(input);
    }
  }
}

function updateCheckoutMinDate(checkinValue, checkoutInput) {
  const checkinDate = new Date(checkinValue);
  const minCheckoutDate = new Date(checkinDate);
  minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
  const minCheckoutStr = minCheckoutDate.toISOString().split('T')[0];
  
  checkoutInput.setAttribute('min', minCheckoutStr);
  
  if (checkoutInput.value && checkoutInput.value <= checkinValue) {
    checkoutInput.value = minCheckoutStr;
  }
}

function showDateError(input, message) {
  let errorDiv = input.parentElement.querySelector('.date-error');
  if (!errorDiv) {
    errorDiv = document.createElement('div');
    errorDiv.className = 'date-error';
    input.parentElement.appendChild(errorDiv);
  }
  errorDiv.textContent = message;
  errorDiv.classList.add('show');
  input.style.borderColor = 'var(--c-red)';
}

function hideDateError(input) {
  const errorDiv = input.parentElement.querySelector('.date-error');
  if (errorDiv) errorDiv.classList.remove('show');
  input.style.borderColor = '';
}

// ── Flight city modal functions (for index.php) ──
let flightCitiesData = [];
let flightCityType = 'from';

function initFlightCityModal(citiesData) {
  flightCitiesData = citiesData;
  
  const searchInput = document.getElementById('flightCitySearch');
  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      renderFlightAllCities(e.target.value);
    });
  }
  
  const modal = document.getElementById('flightCityModal');
  if (modal) {
    modal.addEventListener('click', function(e) {
      if (e.target === this) closeFlightCityModal();
    });
  }
  
  renderFlightPopularCities();
  renderFlightAllCities();
}

function openFlightCityModal(type) {
  flightCityType = type;
  const modal = document.getElementById('flightCityModal');
  const title = document.getElementById('flightModalTitle');
  if (title) title.innerHTML = type === 'from' ? 'Pilih Kota Asal' : 'Pilih Kota Tujuan';
  if (modal) modal.classList.add('open');
  renderFlightPopularCities();
  renderFlightAllCities();
  const searchInput = document.getElementById('flightCitySearch');
  if (searchInput) {
    searchInput.value = '';
    setTimeout(() => searchInput.focus(), 100);
  }
}

function closeFlightCityModal() {
  const modal = document.getElementById('flightCityModal');
  if (modal) modal.classList.remove('open');
}

function selectFlightCity(cityName) {
  const input = flightCityType === 'from' 
    ? document.querySelector('#tab-flight input[name="from"]')
    : document.querySelector('#tab-flight input[name="to"]');
  if (input) input.value = cityName;
  closeFlightCityModal();
}

function renderFlightPopularCities() {
  const popular = flightCitiesData.filter(c => c.popular).slice(0, 6);
  const container = document.getElementById('flightPopularCities');
  if (container) {
    container.innerHTML = popular.map(c => 
      `<div class="city-chip" onclick="selectFlightCity('${c.city.replace(/'/g, "\\'")}')">${c.city} (${c.code})</div>`
    ).join('');
  }
}

function renderFlightAllCities(filter = '') {
  const filtered = flightCitiesData.filter(c => 
    c.city.toLowerCase().includes(filter.toLowerCase()) ||
    c.code.toLowerCase().includes(filter.toLowerCase()) ||
    c.airport.toLowerCase().includes(filter.toLowerCase())
  );
  const container = document.getElementById('flightAllCities');
  if (container) {
    container.innerHTML = filtered.map(c => 
      `<div class="autocomplete-item" style="padding: 10px; border-bottom: 1px solid rgba(0,0,0,0.05); cursor: pointer;" 
            onclick="selectFlightCity('${c.city.replace(/'/g, "\\'")}')">
          <div style="font-weight: 700;">${c.city}</div>
          <div style="font-size: 11px; color: var(--c-text3);">${c.code} · ${c.airport}</div>
       </div>`
    ).join('');
  }
}

// ── Flight city modal for flights.php ──
let indonesiaCities = [];
let currentSearchType = 'from';
let selectedFrom = '';
let selectedTo = '';

function initFlightPageCities(citiesData) {
  indonesiaCities = citiesData;
}

function openCityModal(type) {
  currentSearchType = type;
  const modal = document.getElementById('cityModal');
  const title = document.getElementById('cityModalTitle');
  const icon = document.getElementById('cityModalIcon');
  const label = document.getElementById('cityModalLabel');
  
  if (type === 'from') {
    if (title) title.innerHTML = 'Pilih Kota Asal';
    if (icon) icon.innerHTML = '🛫';
    if (label) label.innerHTML = 'Dari';
  } else {
    if (title) title.innerHTML = 'Pilih Kota Tujuan';
    if (icon) icon.innerHTML = '🛬';
    if (label) label.innerHTML = 'Ke';
  }
  
  const searchInput = document.getElementById('citySearchInput');
  if (searchInput) searchInput.value = '';
  
  const autocompleteResults = document.getElementById('autocompleteResults');
  if (autocompleteResults) autocompleteResults.classList.remove('show');
  
  if (modal) modal.classList.add('open');
  setTimeout(() => {
    if (searchInput) searchInput.focus();
  }, 100);
}

function closeCityModal() {
  const modal = document.getElementById('cityModal');
  if (modal) modal.classList.remove('open');
}

function selectCity(cityName, cityCode) {
  if (currentSearchType === 'from') {
    selectedFrom = cityName;
    const fromInput = document.querySelector('#tab-flight input[name="from"]');
    if (fromInput) fromInput.value = cityName;
  } else {
    selectedTo = cityName;
    const toInput = document.querySelector('#tab-flight input[name="to"]');
    if (toInput) toInput.value = cityName;
  }
  closeCityModal();
  updateRouteDisplay();
  performSearch();
}

function updateRouteDisplay() {
  const routeDisplay = document.getElementById('routeDisplay');
  if (routeDisplay) routeDisplay.innerHTML = `${selectedFrom} → ${selectedTo}`;
}

function performSearch() {
  const form = document.querySelector('#tab-flight .search-form');
  if (form) form.submit();
}

function filterCities(searchTerm) {
  const results = indonesiaCities.filter(city => 
    city.city.toLowerCase().includes(searchTerm.toLowerCase()) ||
    city.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
    city.airport.toLowerCase().includes(searchTerm.toLowerCase())
  );
  
  const container = document.getElementById('autocompleteResults');
  if (!container) return;
  
  if (results.length === 0 && searchTerm.length > 0) {
    container.innerHTML = '<div class="autocomplete-item" style="color: var(--c-text3); text-align:center;">Tidak ditemukan</div>';
    container.classList.add('show');
    return;
  }
  
  if (searchTerm.length === 0) {
    container.classList.remove('show');
    return;
  }
  
  container.innerHTML = results.slice(0, 10).map(city => `
    <div class="autocomplete-item" onclick="selectCity('${city.city.replace(/'/g, "\\'")}', '${city.code}')">
      <div class="autocomplete-city">${city.city}</div>
      <div class="autocomplete-code">${city.code} · ${city.airport}</div>
    </div>
  `).join('');
  
  container.classList.add('show');
}

function bookFlight(id) {
  alert('Pemesanan tiket pesawat ID #' + id + '\n\nFitur ini akan mengarahkan ke halaman checkout pesawat.');
}

function bookActivity(id) {
  alert('Pemesanan Aktivitas ID #' + id + '\n\nFitur ini akan mengarahkan ke halaman checkout aktivitas.');
}

function updateDate(date) {
  selectedDate = date;
  const dateObj = new Date(date);
  const formattedDate = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
  const dateDisplay = document.getElementById('dateDisplay');
  const flightCount = document.getElementById('flightCount');
  if (dateDisplay && flightCount) {
    dateDisplay.innerHTML = formattedDate + ' · ' + flightCount.innerText + ' penerbangan';
  }
}

function shareNow(title, text) {
  if (navigator.share) {
    navigator.share({title: title || 'StayEase', text: text || 'Cek hotel ini di agoda!'});
  } else {
    alert('Link disalin!');
  }
}

// ── Hotel date update for hotel detail page ──
function submitHotelDateForm() {
  const form = document.getElementById('dateForm');
  if (form) form.submit();
}

// ── Initialize Tab System ──
function initTabs() {
  console.log('🚀 Initializing tab system...');
  
  const tabs = document.querySelectorAll('.booking-tab');
  console.log(`📊 Ditemukan ${tabs.length} tab button`);
  
  if (tabs.length === 0) {
    console.warn('⚠️ Tidak ada tab button ditemukan!');
    return;
  }
  
  // Remove any existing listeners and add new ones
  tabs.forEach(tab => {
    // Clone and replace to remove old listeners
    const newTab = tab.cloneNode(true);
    tab.parentNode.replaceChild(newTab, tab);
  });
  
  // Get fresh references
  const freshTabs = document.querySelectorAll('.booking-tab');
  
  // Add click listeners
  freshTabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      const tabName = this.getAttribute('data-tab');
      console.log(`👆 Tab diklik: ${tabName}`);
      if (tabName) {
        switchTab(tabName);
      }
    });
  });
  
  // Ensure default active state
  const hasActive = document.querySelector('.booking-tab.active');
  if (!hasActive) {
    const defaultTab = document.querySelector('.booking-tab[data-tab="hotel"]');
    if (defaultTab) {
      defaultTab.classList.add('active');
      const defaultContent = document.getElementById('tab-hotel');
      if (defaultContent) defaultContent.style.display = 'flex';
    }
  }
  
  console.log('✅ Tab system initialized successfully');
}

// ── DOM Ready ──
document.addEventListener('DOMContentLoaded', function() {
  console.log('📄 DOM ready - Initializing app...');

  // Initialize tab system
  initTabs();
  
  // Init other functions
  try { setMinDates(); } catch(e) { console.warn('setMinDates error:', e); }
  try { initUpsells(); } catch(e) { console.warn('initUpsells error:', e); }
  
  // Setup sort chips
  document.querySelectorAll('.sort-chip').forEach(chip => {
    chip.addEventListener('click', function(e) {
      e.preventDefault();
      const sort = this.dataset.sort;
      const url = new URL(window.location.href);
      url.searchParams.set('sort', sort);
      window.location.href = url.toString();
    });
  });
  
  // Setup hotel date change listeners
  const hotelCheckin = document.querySelector('#dateForm input[name="checkin"]');
  const hotelCheckout = document.querySelector('#dateForm input[name="checkout"]');
  if (hotelCheckin) {
    hotelCheckin.addEventListener('change', submitHotelDateForm);
  }
  if (hotelCheckout) {
    hotelCheckout.addEventListener('change', submitHotelDateForm);
  }
  
  // Close autocomplete when clicking outside
  document.addEventListener('click', function(e) {
    const container = document.getElementById('autocompleteResults');
    const input = document.getElementById('citySearchInput');
    if (container && input && !container.contains(e.target) && e.target !== input) {
      container.classList.remove('show');
    }
  });
  
  // Handle hotel checkin/checkout validation on the homepage
  const homeCheckin = document.getElementById('hotelCheckin');
  const homeCheckout = document.getElementById('hotelCheckout');
  if (homeCheckin && homeCheckout) {
    homeCheckin.addEventListener('change', function() {
      const minCheckout = new Date(this.value);
      minCheckout.setDate(minCheckout.getDate() + 1);
      homeCheckout.min = minCheckout.toISOString().split('T')[0];
      if (homeCheckout.value <= this.value) {
        homeCheckout.value = homeCheckout.min;
      }
    });
  }
  
  console.log('🎉 App initialization complete');
});

// Native-feel press
document.addEventListener('touchstart', () => {}, { passive: true });