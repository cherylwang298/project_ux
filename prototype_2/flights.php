<?php
session_start();
require '_data.php';
require '_head.php';

$from = $_GET['from'] ?? 'Surabaya';
$to   = $_GET['to']   ?? 'Jakarta';
$dep  = $_GET['dep_date'] ?? date('Y-m-d', strtotime('+1 day'));
$sort = $_GET['sort'] ?? 'recommended';

// Filter flights based on selected cities
$list = array_filter($FLIGHTS, function($f) use ($from, $to) {
    return ($f['from_city'] === $from || $f['from'] === $from) && 
           ($f['to_city'] === $to || $f['to'] === $to);
});

if($sort === 'price_asc')  usort($list, fn($a,$b) => $a['price'] - $b['price']);
if($sort === 'price_desc') usort($list, fn($a,$b) => $b['price'] - $a['price']);

// Get popular cities
$popularCities = array_filter($INDONESIA_CITIES, fn($c) => isset($c['popular']) && $c['popular'] === true);
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Cari Penerbangan — Agoda</title><?=$font?><?=$css?>
<style>
/* Autocomplete styles */
.search-field {
    position: relative;
}

.autocomplete-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: var(--r-md);
    border: 1px solid var(--c-border);
    max-height: 280px;
    overflow-y: auto;
    z-index: 1000;
    margin-top: 4px;
    box-shadow: var(--sh-lg);
    display: none;
}

.autocomplete-list.show {
    display: block;
}

.autocomplete-item {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    transition: background 0.1s;
    display: flex;
    flex-direction: column;
}

.autocomplete-item:last-child {
    border-bottom: none;
}

.autocomplete-item:hover,
.autocomplete-item.selected {
    background: var(--a-soft);
}

.autocomplete-city {
    font-size: 14px;
    font-weight: 800;
    color: var(--c-text);
}

.autocomplete-code {
    font-size: 10px;
    color: var(--c-text3);
    font-weight: 600;
    margin-top: 2px;
}

/* Date picker styling */
input[type="date"] {
    cursor: pointer;
    position: relative;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    background: var(--a-grad);
    border-radius: 50%;
    padding: 4px;
    cursor: pointer;
    opacity: 1;
}

/* Select styling */
select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23E84393' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 8px center;
    padding-right: 24px;
}

/* Modal sheet for city selection */
.modal-sheet {
    max-height: 90vh;
    overflow-y: auto;
}

.city-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: var(--a-soft);
    border: 1px solid var(--c-border);
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    color: var(--c-text);
    cursor: pointer;
    transition: all 0.1s;
}

.city-chip:active {
    transform: scale(0.96);
    background: var(--a-grad);
    color: white;
}
</style>
</head><body>

<header class="app-header">
  <div class="header-inner">
    <a href="index.php" class="hb-back">←</a>
    <div style="text-align:center;">
      <div style="font-size:14px;font-weight:800;letter-spacing:-0.3px;" id="routeDisplay"><?=htmlspecialchars($from)?> → <?=htmlspecialchars($to)?></div>
      <div style="font-size:10px;color:var(--c-text3);" id="dateDisplay"><?=date('d M Y', strtotime($dep))?> · <span id="flightCount"><?=count($list)?></span> penerbangan</div>
    </div>
    <button class="icon-btn" onclick="toggleModal('filterSheet')">⚙️</button>
  </div>
</header>

<div class="page-content">
  <div class="filter-chips" style="padding:0 0 14px;">
    <a href="#" data-sort="recommended" class="chip sort-chip <?=$sort==='recommended'?'active':''?>">✦ Terbaik</a>
    <a href="#" data-sort="price_asc" class="chip sort-chip <?=$sort==='price_asc'?'active':''?>">💰 Termurah</a>
    <a href="#" data-sort="price_desc" class="chip sort-chip <?=$sort==='price_desc'?'active':''?>">💸 Termahal</a>
  </div>

  <div style="font-size:12px;color:var(--c-text2);font-weight:600;margin-bottom:14px;" id="resultCount"><?=count($list)?> penerbangan ditemukan</div>

  <div id="flightList">
  <?php if(count($list) > 0): ?>
    <?php foreach($list as $f): ?>
    <div class="flight-card" onclick="bookFlight(<?=$f['id']?>)">
      <div class="flight-head">
        <div>
          <div class="airline-name"><?=$f['logo']?> <?=$f['airline']?></div>
          <div class="flight-class"><?=$f['airline_code']?> · <?=$f['class']?></div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:11px;color:rgba(255,255,255,0.85);font-weight:700;"><?=date('d M', strtotime($dep))?></div>
          <div style="font-size:10px;color:rgba(255,255,255,0.65);margin-top:1px;"><?=$f['stops']?></div>
        </div>
      </div>
      <div class="flight-body">
        <div class="flight-route">
          <div class="route-end">
            <div class="code"><?=$f['from']?></div>
            <div class="city"><?=$f['from_city']?></div>
            <div class="time"><?=$f['dep']?></div>
          </div>
          <div class="route-mid">
            <div class="route-line">
              <div class="route-dot"></div>
              <div class="route-dash"></div>
              <div class="route-plane">✈</div>
              <div class="route-dash"></div>
              <div class="route-dot"></div>
            </div>
            <div class="route-dur"><?=$f['duration']?></div>
            <div class="route-stops"><?=$f['stops']?></div>
          </div>
          <div class="route-end" style="text-align:right;">
            <div class="code"><?=$f['to']?></div>
            <div class="city"><?=$f['to_city']?></div>
            <div class="time"><?=$f['arr']?></div>
          </div>
        </div>
        <div class="flight-footer">
          <div>
            <div class="flight-seats">🔥 <?=$f['seats']?> kursi tersisa</div>
            <div style="font-size:10px;color:var(--c-green);font-weight:700;margin-top:2px;">✓ Bagasi 20kg</div>
          </div>
          <div style="text-align:right;">
            <div class="flight-price"><?=rp($f['price'])?></div>
            <div class="flight-price-sub">per orang · sudah incl. pajak</div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div style="text-align:center;padding:40px 20px;">
      <div style="font-size:48px;margin-bottom:16px;">✈️</div>
      <div style="font-size:16px;font-weight:800;margin-bottom:8px;">Tidak ada penerbangan langsung</div>
      <div style="font-size:12px;color:var(--c-text2);">Coba cari rute lain atau tanggal berbeda</div>
    </div>
  <?php endif; ?>
  </div>
</div>

<!-- Filter modal -->
<div class="modal-overlay filter-sheet" id="filterSheet" onclick="closeModal('filterSheet')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title">Filter Penerbangan</div>
    <form method="GET" id="filterForm">
      <input type="hidden" name="from" id="filterFrom" value="<?=htmlspecialchars($from)?>">
      <input type="hidden" name="to" id="filterTo" value="<?=htmlspecialchars($to)?>">
      <input type="hidden" name="dep_date" id="filterDepDate" value="<?=$dep?>">
      <div class="filter-group">
        <div class="filter-group-title">Urutkan</div>
        <label class="sort-opt"><input type="radio" name="sort" value="recommended" <?=$sort==='recommended'?'checked':''?>> ✦ Terbaik</label>
        <label class="sort-opt"><input type="radio" name="sort" value="price_asc" <?=$sort==='price_asc'?'checked':''?>> 💰 Harga Termurah</label>
        <label class="sort-opt"><input type="radio" name="sort" value="price_desc" <?=$sort==='price_desc'?'checked':''?>> 💸 Harga Termahal</label>
      </div>
      <button type="submit" class="btn-primary">Terapkan Filter</button>
    </form>
  </div>
</div>

<!-- City Selection Modal -->
<div class="modal-overlay" id="cityModal" onclick="closeCityModal()">
  <div class="modal-sheet" style="border-radius: 28px;" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title" id="cityModalTitle">Pilih Kota Asal</div>
    
    <!-- Search input -->
    <div class="search-field" style="margin-bottom: 16px;">
      <span class="field-icon" id="cityModalIcon">🛫</span>
      <div class="field-content" style="position: relative;">
        <label id="cityModalLabel">Cari kota atau bandara</label>
        <input type="text" id="citySearchInput" placeholder="Ketik nama kota atau kode bandara..." autocomplete="off" 
               style="width:100%;background:none;border:none;outline:none;color:var(--c-text);font-family:var(--f);font-size:13px;font-weight:700;padding:0;">
        <div id="autocompleteResults" class="autocomplete-list"></div>
      </div>
    </div>
    
    <!-- Popular cities -->
    <div style="margin-top: 8px;">
      <div style="font-size: 11px; color: var(--c-text3); font-weight: 700; margin-bottom: 12px; padding: 0 4px;">✈️ Kota Populer</div>
      <div id="popularCities" style="display: flex; flex-wrap: wrap; gap: 10px;">
        <?php foreach($popularCities as $city): ?>
        <div class="city-chip" data-city="<?=htmlspecialchars($city['city'])?>" data-code="<?=$city['code']?>">
          <?=$city['city']?> (<?=$city['code']?>)
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    
    <!-- All cities list -->
    <div style="margin-top: 20px;">
      <div style="font-size: 11px; color: var(--c-text3); font-weight: 700; margin-bottom: 12px; padding: 0 4px;">🌍 Semua Kota</div>
      <div id="allCitiesList" style="max-height: 300px; overflow-y: auto;">
        <?php foreach($INDONESIA_CITIES as $city): ?>
        <div class="autocomplete-item" data-city="<?=htmlspecialchars($city['city'])?>" data-code="<?=$city['code']?>" 
             style="cursor:pointer; padding: 10px 12px;">
          <div class="autocomplete-city"><?=$city['city']?></div>
          <div class="autocomplete-code"><?=$city['code']?> · <?=$city['airport']?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?=nav('flights')?>
<script src="assets/app.js"></script>
<script>
// Data kota dari PHP
const indonesiaCities = <?= json_encode($INDONESIA_CITIES) ?>;

let currentSearchType = 'from';
let selectedFrom = '<?= htmlspecialchars($from) ?>';
let selectedTo = '<?= htmlspecialchars($to) ?>';
let selectedDate = '<?= $dep ?>';

// Sort chips
document.querySelectorAll('.sort-chip').forEach(chip => {
    chip.addEventListener('click', function(e) {
        e.preventDefault();
        const sort = this.dataset.sort;
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sort);
        window.location.href = url.toString();
    });
});

function openCityModal(type) {
    currentSearchType = type;
    const modal = document.getElementById('cityModal');
    const title = document.getElementById('cityModalTitle');
    const icon = document.getElementById('cityModalIcon');
    const label = document.getElementById('cityModalLabel');
    
    if (type === 'from') {
        title.innerHTML = 'Pilih Kota Asal';
        icon.innerHTML = '🛫';
        label.innerHTML = 'Dari';
    } else {
        title.innerHTML = 'Pilih Kota Tujuan';
        icon.innerHTML = '🛬';
        label.innerHTML = 'Ke';
    }
    
    document.getElementById('citySearchInput').value = '';
    document.getElementById('autocompleteResults').classList.remove('show');
    modal.classList.add('open');
    setTimeout(() => document.getElementById('citySearchInput').focus(), 100);
}

function closeCityModal() {
    document.getElementById('cityModal').classList.remove('open');
}

function selectCity(cityName, cityCode) {
    if (currentSearchType === 'from') {
        selectedFrom = cityName;
        document.querySelector('#tab-flight input[name="from"]').value = cityName;
    } else {
        selectedTo = cityName;
        document.querySelector('#tab-flight input[name="to"]').value = cityName;
    }
    closeCityModal();
    updateRouteDisplay();
    performSearch();
}

function updateRouteDisplay() {
    document.getElementById('routeDisplay').innerHTML = `${selectedFrom} → ${selectedTo}`;
}

function performSearch() {
    const form = document.querySelector('#tab-flight .search-form');
    if (form) {
        form.submit();
    }
}

function filterCities(searchTerm) {
    const results = indonesiaCities.filter(city => 
        city.city.toLowerCase().includes(searchTerm.toLowerCase()) ||
        city.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
        city.airport.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    const container = document.getElementById('autocompleteResults');
    
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

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Replace form with enhanced version
    const flightTab = document.getElementById('tab-flight');
    if (flightTab) {
        flightTab.innerHTML = `
            <form class="search-form" method="GET" action="flights.php" id="flightSearchForm">
                <div class="search-row">
                    <div class="search-field half" onclick="openCityModal('from')" style="cursor: pointer;">
                        <span class="field-icon">🛫</span>
                        <div class="field-content">
                            <label>Dari</label>
                            <input type="text" name="from" placeholder="SUB - Surabaya" value="${selectedFrom.replace(/'/g, "\\'")}" readonly style="background:transparent;cursor:pointer;font-weight:700;">
                        </div>
                    </div>
                    <div class="search-field half" onclick="openCityModal('to')" style="cursor: pointer;">
                        <span class="field-icon">🛬</span>
                        <div class="field-content">
                            <label>Ke</label>
                            <input type="text" name="to" placeholder="CGK - Jakarta" value="${selectedTo.replace(/'/g, "\\'")}" readonly style="background:transparent;cursor:pointer;font-weight:700;">
                        </div>
                    </div>
                </div>
                <div class="search-row">
                    <div class="search-field half">
                        <span class="field-icon">📅</span>
                        <div class="field-content">
                            <label>Berangkat</label>
                            <input type="date" name="dep_date" value="${selectedDate}" onchange="updateDate(this.value)">
                        </div>
                    </div>
                    <div class="search-field half">
                        <span class="field-icon">👤</span>
                        <div class="field-content">
                            <label>Penumpang</label>
                            <select name="pax">
                                <option>1 Dewasa</option>
                                <option>2 Dewasa</option>
                                <option>3 Dewasa</option>
                                <option>4 Dewasa</option>
                                <option>5 Dewasa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Cari Penerbangan
                </button>
            </form>
        `;
    }
    
    // Setup search input for autocomplete
    const searchInput = document.getElementById('citySearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            filterCities(e.target.value);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const firstItem = document.querySelector('#autocompleteResults .autocomplete-item');
                if (firstItem && firstItem.onclick) {
                    firstItem.click();
                }
            }
        });
    }
    
    // Setup popular city chips
    document.querySelectorAll('.city-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const city = this.dataset.city;
            const code = this.dataset.code;
            selectCity(city, code);
        });
    });
    
    // Setup all cities list items
    document.querySelectorAll('#allCitiesList .autocomplete-item').forEach(item => {
        item.addEventListener('click', function() {
            const city = this.dataset.city;
            const code = this.dataset.code;
            selectCity(city, code);
        });
    });
    
    // Close autocomplete when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('autocompleteResults');
        const input = document.getElementById('citySearchInput');
        if (container && input && !container.contains(e.target) && e.target !== input) {
            container.classList.remove('show');
        }
    });
});

function updateDate(date) {
    selectedDate = date;
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    document.getElementById('dateDisplay').innerHTML = formattedDate + ' · ' + document.getElementById('flightCount').innerText + ' penerbangan';
}

function bookFlight(id) {
    alert('Pemesanan tiket pesawat ID #' + id + '\n\nFitur ini akan mengarahkan ke halaman checkout pesawat.');
}

function toggleModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.toggle('open');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('open');
}
</script>
</body></html>