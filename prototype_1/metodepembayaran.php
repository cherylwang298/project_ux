<?php
session_start();

function get_user_value($key, $default) {
    if (isset($_SESSION[$key]) && $_SESSION[$key] !== '') {
        return htmlspecialchars($_SESSION[$key], ENT_QUOTES, 'UTF-8');
    }

    if (isset($_GET[$key]) && $_GET[$key] !== '') {
        return htmlspecialchars($_GET[$key], ENT_QUOTES, 'UTF-8');
    }

    return $default;
}

$name = get_user_value('name', 'Jessica Gabriel');
$email = get_user_value('email', 'jessica.gabriel@example.com');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #b8cfe8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 16px;
            font-family: 'DM Sans', sans-serif;
        }
        .phone-frame {
            width: 375px; height: 812px; border-radius: 44px; border: 9px solid #18181b;
            position: relative; overflow: hidden; display: flex; flex-direction: column;
            background: linear-gradient(165deg, #1e57b8 0%, #2563eb 18%, #4a90d9 36%, #82b8f0 54%, #c5deff 72%, #ebf4ff 88%, #f5f9ff 100%);
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
        }
        .phone-notch { position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 100px; height: 26px; background: #18181b; border-radius: 14px; z-index: 500; }
        .blob { position: absolute; border-radius: 50%; pointer-events: none; }
        .blob-top { width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%); top: -80px; right: -80px; opacity: .7; }
        .content-area { flex: 1; overflow-y: auto; scrollbar-width: none; padding-bottom: 120px; position: relative; z-index: 10; }
        .content-area::-webkit-scrollbar { display: none; }
        .header-card { margin: 24px 20px 16px; padding: 22px 20px; background: rgba(255,255,255,.42); backdrop-filter: blur(24px); border-radius: 32px; border: 1px solid rgba(255,255,255,.75); box-shadow: 0 14px 30px rgba(0,0,0,.12); display:flex; flex-direction:column; align-items:center; text-align:center; }
        .avatar-container { margin-bottom: 12px; }
        .avatar-img { width: 72px; height:72px; border-radius:50%; object-fit:cover; border:3px solid rgba(255,255,255,.95); }
        .user-name { font-size:18px; font-weight:700; color:#0c2461; margin-bottom:4px; font-family:'Playfair Display', serif; }
        .user-email { font-size:13px; font-weight:500; color:rgba(12,36,97,.72); }

        .card { margin: 18px 20px 18px; border-radius: 28px; background: rgba(255,255,255,.34); border: 1px solid rgba(255,255,255,.65); box-shadow: 0 16px 32px rgba(0,0,0,.08); overflow: hidden; backdrop-filter: blur(20px); }
        .card-header { display:flex; justify-content:space-between; align-items:center; padding: 18px 20px; }
        .card-header h2 { font-size:16px; font-weight:800; color:#1D4ED8; }
        .btn-add { display:inline-flex; align-items:center; gap:8px; background: linear-gradient(135deg, #4f8bff, #1d4ed8); color:#fff; border:none; border-radius:18px; padding:12px 16px; font-weight:700; font-size:12px; cursor:pointer; box-shadow: 0 14px 32px rgba(29,78,216,.18); }
        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 16px 34px rgba(29,78,216,.24); }

        .method-list { padding: 0 18px 20px; }
        .method-card { background: linear-gradient(180deg, #f7fbff 0%, #eef5ff 100%); border-radius: 20px; margin-bottom: 14px; padding: 14px; border: 1px solid rgba(37,99,235,.12); }
        .method-card.type-bank { background: linear-gradient(180deg,#eef6ff 0%,#e6f0ff 100%); border-color: rgba(37,99,235,.18); }
        .method-card.type-ewallet { background: linear-gradient(180deg,#f0fff6 0%,#e6fff0 100%); border-color: rgba(16,185,129,.18); }
        .method-card.type-cc { background: linear-gradient(180deg,#f9f0ff 0%,#f3e6ff 100%); border-color: rgba(139,92,246,.18); }
        .method-card.type-other { background: linear-gradient(180deg,#fbfbfb 0%,#f2f2f2 100%); border-color: rgba(107,114,128,.12); }
        .method-row { display:flex; justify-content:flex-start; gap:12px; align-items:center; }
        .method-brand-icon { width:44px; height:28px; display:flex; align-items:center; justify-content:center; margin-right:6px; }
        .method-info { display:flex; flex-direction:column; }
        .method-name { font-size:14px; font-weight:800; color:#152d55; }
        .method-meta { font-size:12px; color:#6b7b9c; margin-top:6px; }
        .method-actions { display:flex; gap:10px; margin-top:10px; }
        .action-pill { min-width:100px; border:none; border-radius:18px; padding:10px 14px; font-size:12px; font-weight:700; cursor:pointer; }
        .action-pill.edit { background:#e0ecff; color:#2563eb; }
        .action-pill.delete { background:#fee3e3; color:#b91c1c; }

        .empty-state { margin: 0 20px; padding: 24px 18px; text-align:center; background: rgba(255,255,255,.9); border-radius: 24px; color: rgba(12,36,97,.72); font-size:13px; }

        .form-modal { position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(12,36,97,.35); display:none; align-items:center; justify-content:center; padding:24px; z-index:500; }
        .form-modal.active { display:flex; }
        .form-card { width:100%; max-width:360px; background:#f9fbff; border-radius:32px; padding:24px 20px; box-shadow:0 30px 70px rgba(0,0,0,.18); }
        .form-card h3 { font-size:18px; font-weight:700; color:#0c2461; margin-bottom:14px; }
        .field-group { margin-bottom:12px; }
        .field-group label { display:block; font-size:12px; font-weight:700; color:rgba(12,36,97,.7); margin-bottom:6px; }
        .field-group input, .field-group select { width:100%; border-radius:12px; border:1px solid rgba(12,36,97,.12); padding:10px 12px; font-size:13px; }
        .form-actions { display:flex; gap:12px; margin-top:12px; }
        .btn-save { background:#1D4ED8; color:white; border:none; border-radius:12px; padding:12px 0; font-weight:700; flex:1; }
        .btn-cancel { background:rgba(255,255,255,.92); color:#0c2461; border:1px solid rgba(12,36,97,.12); border-radius:12px; padding:12px 0; flex:1; }
        .btn-primary-add { background: linear-gradient(135deg,#4f8bff,#1d4ed8); color: #fff; border:none; border-radius:12px; padding:12px 0; font-weight:800; flex:1; box-shadow: 0 14px 34px rgba(79,139,255,.18); }

        .select-list { display:flex; flex-direction:column; gap:10px; margin-top:8px; }
        .select-item { display:flex; align-items:center; gap:12px; padding:12px; border-radius:12px; background: rgba(255,255,255,.95); cursor:pointer; border:1px solid rgba(12,36,97,.06); }
        .select-item.selected { box-shadow: 0 8px 20px rgba(0,0,0,.06); border-color: rgba(37,99,235,.12); }
        .select-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; }
        .select-label { font-weight:700; color:#0c2461; }

        .action-row { display:flex; justify-content:center; margin: 0 20px 18px; }
        .action-button { width:100%; text-align:center; background: rgba(255,255,255,.95); color:#1D4ED8; border:1px solid rgba(37,99,235,.3); box-shadow:0 10px 24px rgba(0,0,0,.08); padding:14px 0; border-radius:18px; font-size:14px; font-weight:700; }
        .action-button:hover { transform: translateY(-1px); background:white; }

        a { text-decoration:none; color:inherit; }

        html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone-frame {
            border-color: #0f172a;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%);
            box-shadow: 0 40px 90px rgba(0,0,0,.8);
        }
        html.dark-mode .content-area,
        html.dark-mode .header-card,
        html.dark-mode .card,
        html.dark-mode .method-card,
        html.dark-mode .form-card,
        html.dark-mode .form-modal,
        html.dark-mode .action-button,
        html.dark-mode .empty-state,
        html.dark-mode .select-item {
            background: rgba(15,23,42,.92);
            border-color: rgba(148,163,184,.2);
            color: #e2e8f0;
        }
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .method-name,
        html.dark-mode .method-meta,
        html.dark-mode .select-label,
        html.dark-mode .form-card h3,
        html.dark-mode label {
            color: #e2e8f0 !important;
        }
        html.dark-mode input,
        html.dark-mode select {
            background: rgba(15,23,42,.96);
            color: #e2e8f0;
            border-color: rgba(148,163,184,.3);
        }
        html.dark-mode .btn-save,
        html.dark-mode .btn-cancel,
        html.dark-mode .btn-primary-add {
            background: rgba(37,99,235,.95);
            color: white;
            border-color: rgba(37,99,235,.35);
        }
        html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone-frame,
        html.dark-mode .phone {
            border-color: #0f172a !important;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%) !important;
            box-shadow: 0 40px 90px rgba(0,0,0,.8) !important;
        }
        html.dark-mode .content-area,
        html.dark-mode .header-card,
        html.dark-mode .card,
        html.dark-mode .method-card,
        html.dark-mode .form-card,
        html.dark-mode .form-modal,
        html.dark-mode .action-button,
        html.dark-mode .empty-state,
        html.dark-mode .select-item {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .method-name,
        html.dark-mode .method-meta,
        html.dark-mode .select-label,
        html.dark-mode .form-card h3,
        html.dark-mode label {
            color: #e2e8f0 !important;
        }
        html.dark-mode input,
        html.dark-mode select {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
        html.dark-mode .btn-save,
        html.dark-mode .btn-cancel,
        html.dark-mode .btn-primary-add {
            background: rgba(37,99,235,.95) !important;
            color: white !important;
            border-color: rgba(37,99,235,.35) !important;
        }
    </style>
</head>
<body>
    <div class="phone-frame">
        <div class="phone-notch"></div>
        <div class="blob blob-top"></div>
        <div class="content-area">
            <div class="header-card">
                <div class="avatar-container">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=500" alt="Profil" class="avatar-img">
                </div>
                <div class="user-name"><?php echo $name; ?></div>
                <div class="user-email"><?php echo $email; ?></div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Metode Pembayaran</h2>
                    <button class="btn-add" id="openFormBtn">Tambah</button>
                </div>
                <div class="method-list" id="methodList"></div>
                <div class="empty-state" id="emptyState">Belum ada metode pembayaran. Tekan Tambah untuk menambahkan.</div>
            </div>

            <div class="action-row">
                <a href="profile.php" class="action-button">Kembali ke Profil</a>
            </div>
        </div>

        <div class="form-modal" id="formModal">
            <div class="form-card">
                <!-- Selection view -->
                <div id="selectView">
                    <h3>Pilih Metode Pembayaran</h3>
                    <div class="select-list" id="selectList">
                        <div class="select-item" data-name="Paypal" data-type="E-Wallet">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">Paypal</div>
                                <div style="font-size:12px;color:#6b7b9c;">E-Wallet</div>
                            </div>
                        </div>
                        <div class="select-item" data-name="Kartu Kredit" data-type="Kartu Kredit">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">Kartu Kredit</div>
                                <div style="font-size:12px;color:#6b7b9c;">Visa / Mastercard</div>
                            </div>
                        </div>
                        <div class="select-item" data-name="Apple Pay" data-type="E-Wallet">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">Apple Pay</div>
                                <div style="font-size:12px;color:#6b7b9c;">E-Wallet</div>
                            </div>
                        </div>
                        <div class="select-item" data-name="Google Pay" data-type="E-Wallet">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">Google Pay</div>
                                <div style="font-size:12px;color:#6b7b9c;">E-Wallet</div>
                            </div>
                        </div>
                        <div class="select-item" data-name="BCA" data-type="Bank">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">BCA</div>
                                <div style="font-size:12px;color:#6b7b9c;">Bank</div>
                            </div>
                        </div>
                        <div class="select-item" data-name="OVO" data-type="E-Wallet">
                            <div class="select-icon" style="background:transparent"></div>
                            <div>
                                <div class="select-label">OVO</div>
                                <div style="font-size:12px;color:#6b7b9c;">E-Wallet</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions" style="margin-top:14px;">
                        <button type="button" class="btn-cancel" id="cancelSelect">Batal</button>
                        <button type="button" class="btn-primary-add" id="proceedAdd">Tambah</button>
                    </div>
                </div>

                <!-- Detail form view (hidden initially) -->
                <div id="detailView" style="display:none;">
                    <h3 id="formTitle">Tambah Metode Pembayaran</h3>
                    <div class="field-group" style="margin-bottom:16px;">
                        <div id="selectedSummary" style="font-size:14px; font-weight:700; color:#1D4ED8;"></div>
                    </div>
                    <div class="field-group">
                        <label for="accountName">Nama Pemilik / Akun</label>
                        <input id="accountName" type="text" placeholder="Nama pemilik atau akun">
                    </div>
                    <div class="field-group">
                        <label for="accountNumber" id="accountNumberLabel">Nomor Rekening / Akun</label>
                        <input id="accountNumber" type="text" placeholder="Nomor rekening atau ID akun">
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" id="backToSelect">Kembali</button>
                        <button type="button" class="btn-save" id="saveForm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const STORAGE_KEY = 'paymentMethods';
        const openFormBtn = document.getElementById('openFormBtn');
        const formModal = document.getElementById('formModal');
        const cancelForm = document.getElementById('cancelForm');
        const saveForm = document.getElementById('saveForm');
        const formTitle = document.getElementById('formTitle');
        const methodList = document.getElementById('methodList');
        const emptyState = document.getElementById('emptyState');

        // detail form elements (inside detailView)
        const accountName = document.getElementById('accountName');
        const accountNumber = document.getElementById('accountNumber');
        const selectedSummary = document.getElementById('selectedSummary');
        const selectList = document.getElementById('selectList');
        const proceedAdd = document.getElementById('proceedAdd');
        const cancelSelect = document.getElementById('cancelSelect');
        const backToSelect = document.getElementById('backToSelect');
        const selectView = document.getElementById('selectView');
        const detailView = document.getElementById('detailView');

        let methods = [];
        let editIndex = null;

        function loadMethods() {
            const stored = window.localStorage.getItem(STORAGE_KEY);
            methods = stored ? JSON.parse(stored) : [];
            renderMethods();
        }

        function saveMethods() {
            window.localStorage.setItem(STORAGE_KEY, JSON.stringify(methods));
            renderMethods();
        }

        function renderMethods() {
            methodList.innerHTML = '';
            if (methods.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            emptyState.style.display = 'none';

            methods.forEach((m, index) => {
                const card = document.createElement('div');
                const typeClass = getTypeClass(m.type);
                card.className = 'method-card ' + typeClass;
                card.innerHTML = `
                    <div class="method-row">
                        <div class="method-info">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div class="method-brand-icon">${getBrandSvg(m.name, m.type)}</div>
                                <div class="method-name">${m.name} <span style="font-weight:600; color:#6b7b9c; font-size:12px;">· ${m.type || '-'}</span></div>
                            </div>
                                <div class="method-meta">${m.accountName || '-'} · ${m.accountNumber || '-'}</div>
                        </div>
                    </div>
                    <div class="method-actions">
                        <button class="action-pill edit" onclick="openEditForm(${index})">Edit</button>
                        <button class="action-pill delete" onclick="deleteMethod(${index})">Hapus</button>
                    </div>
                `;
                methodList.appendChild(card);
            });
        }

        function getTypeClass(type) {
            if (!type) return 'type-other';
            const t = type.toLowerCase();
            if (t === 'bank') return 'type-bank';
            if (t === 'e-wallet' || t === 'ewallet' || t === 'e wallet') return 'type-ewallet';
            if (t === 'kartu kredit' || t === 'kartu' || t === 'credit card') return 'type-cc';
            return 'type-other';
        }

        function getBrandSvg(name, type) {
            const n = (name || '').toLowerCase();
            if (n.includes('paypal')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#003087"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12" fill="#fff" font-family="sans-serif">P</text>
                    </svg>`;
            }
            if (n.includes('ovo')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#6f2dbd"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12" fill="#fff" font-family="sans-serif">OVO</text>
                    </svg>`;
            }
            if (n.includes('google')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#4285F4"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12" fill="#fff" font-family="sans-serif">G</text>
                    </svg>`;
            }
            if (n.includes('apple')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#111"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12" fill="#fff" font-family="sans-serif"></text>
                    </svg>`;
            }
            if (n.includes('bca')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#00539f"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="12" fill="#fff" font-family="sans-serif">BCA</text>
                    </svg>`;
            }
            if (n.includes('kartu') || n.includes('credit') || n.includes('master')) {
                return `
                    <svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg">
                        <rect rx="6" width="40" height="24" fill="#ff9f1c"/>
                        <circle cx="16" cy="12" r="6" fill="#eb001b" />
                        <circle cx="24" cy="12" r="6" fill="#f79e1b" />
                    </svg>`;
            }
            // default: simple badge
            const color = getTypeClass(type) === 'type-ewallet' ? '#10b981' : (getTypeClass(type) === 'type-bank' ? '#3b82f6' : '#6b7280');
            return `<svg width="40" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg"><rect rx="6" width="40" height="24" fill="${color}"/></svg>`;
        }

        function openForm(mode = 'add') {
            formModal.classList.add('active');
            if (mode === 'add') {
                formTitle.textContent = 'Tambah Metode Pembayaran';
                editIndex = null;
                selectedOption = null;
                accountName.value = '';
                accountNumber.value = '';
                selectedSummary.textContent = '';
                // show selection view first
                selectView.style.display = '';
                detailView.style.display = 'none';
                // clear selection highlight
                document.querySelectorAll('.select-item').forEach(i => i.classList.remove('selected'));
                updateFormFields();
            }
        }

        function closeForm() { formModal.classList.remove('active'); }

        function openEditForm(index) {
            const m = methods[index];
            editIndex = index;
            selectedOption = { name: m.name, type: m.type };
            formTitle.textContent = 'Edit Metode Pembayaran';
            selectedSummary.textContent = `${m.name} · ${m.type}`;
            accountName.value = m.accountName;
            accountNumber.value = m.accountNumber;
            // show detail view for editing
            selectView.style.display = 'none';
            detailView.style.display = '';
            updateFormFields();
            formModal.classList.add('active');
        }

        function deleteMethod(index) {
            if (!confirm('Hapus metode pembayaran ini?')) return;
            methods.splice(index, 1);
            saveMethods();
        }

        function validateForm() {
            if (!selectedOption) {
                alert('Pilih metode pembayaran terlebih dahulu.');
                return false;
            }
            if (accountName.value.trim() === '') {
                alert('Mohon isi nama pemilik atau akun.');
                accountName.focus();
                return false;
            }
            if (accountNumber.value.trim() === '') {
                alert(selectedOption.type.toLowerCase().includes('e') ? 'Mohon isi nomor telepon untuk E-Wallet.' : 'Mohon isi nomor rekening.');
                accountNumber.focus();
                return false;
            }
            return true;
        }

        function updateFormFields() {
            const label = document.getElementById('accountNumberLabel');
            if (!label) return;
            const type = selectedOption ? selectedOption.type : '';
            if (type.toLowerCase().includes('e')) {
                label.textContent = 'Nomor Telepon (untuk E-Wallet)';
                accountNumber.type = 'tel';
                accountNumber.placeholder = '+62 812-3456-7890';
            } else {
                label.textContent = 'Nomor Rekening / Akun';
                accountNumber.type = 'text';
                accountNumber.placeholder = 'Nomor rekening atau ID akun';
            }
        }
        
        function saveFormHandler() {
            if (!validateForm()) return;

            const record = {
                name: selectedOption.name,
                type: selectedOption.type,
                accountName: accountName.value.trim(),
                accountNumber: accountNumber.value.trim(),
            };

            if (editIndex !== null) methods[editIndex] = record; else methods.push(record);
            saveMethods();
            closeForm();
        }

        // selection list behavior
        let selectedOption = null;
        // initialize icons for select items
        document.querySelectorAll('.select-item').forEach(item => {
            const iconEl = item.querySelector('.select-icon');
            if (iconEl && iconEl.innerHTML.trim() === '') {
                iconEl.innerHTML = getBrandSvg(item.dataset.name, item.dataset.type);
            }
        });

        selectList.addEventListener('click', (e) => {
            const item = e.target.closest('.select-item');
            if (!item) return;
            document.querySelectorAll('.select-item').forEach(i => i.classList.remove('selected'));
            item.classList.add('selected');
            selectedOption = { name: item.dataset.name, type: item.dataset.type };
        });

        proceedAdd.addEventListener('click', () => {
            if (!selectedOption) {
                alert('Pilih metode terlebih dahulu.');
                return;
            }
            // prefill detail form and show it
            selectedSummary.textContent = `${selectedOption.name} · ${selectedOption.type}`;
            accountName.value = '';
            accountNumber.value = '';
            selectView.style.display = 'none';
            detailView.style.display = '';
            updateFormFields();
        });

        cancelSelect.addEventListener('click', closeForm);
        backToSelect.addEventListener('click', () => {
            // go back to selection
            selectView.style.display = '';
            detailView.style.display = 'none';
        });

        openFormBtn.addEventListener('click', () => openForm('add'));
        cancelForm.addEventListener('click', closeForm);
        formModal.addEventListener('click', (e) => { if (e.target === formModal) closeForm(); });
        saveForm.addEventListener('click', saveFormHandler);

        loadMethods();
    </script>
    <script src="theme.js"></script>
</body>
</html>
