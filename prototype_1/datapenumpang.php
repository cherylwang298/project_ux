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
    <title>Data Penumpang Tersimpan</title>
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
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: linear-gradient(165deg, #1e57b8 0%, #2563eb 18%, #4a90d9 36%, #82b8f0 54%, #c5deff 72%, #ebf4ff 88%, #f5f9ff 100%);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
        }
        .phone-notch {
            position: absolute;
            top: 8px; left: 50%; transform: translateX(-50%);
            width: 100px; height: 26px; background: #18181b; border-radius: 14px; z-index: 500;
        }
        .blob { position: absolute; border-radius: 50%; pointer-events: none; }
        .blob-top { width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%); top: -80px; right: -80px; opacity: .7; }
        .content-area { flex: 1; overflow-y: auto; scrollbar-width: none; padding-bottom: 120px; position: relative; z-index: 10; }
        .content-area::-webkit-scrollbar { display: none; }
        .header-card {
            margin: 68px 20px 16px;
            padding: 22px 20px;
            background: rgba(255,255,255,.42);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 14px 30px rgba(0,0,0,.12);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .avatar-container { margin-bottom: 16px; }
        .avatar-img {
            width: 88px; height: 88px; border-radius: 50%; object-fit: cover;
            border: 3px solid rgba(255,255,255,.95); box-shadow: 0 10px 24px rgba(0,0,0,.12);
        }
        .user-name { font-size: 22px; font-weight: 700; color: #0c2461; margin-bottom: 4px; font-family: 'Playfair Display', serif; }
        .user-email { font-size: 13px; font-weight: 500; color: rgba(12,36,97,.72); margin-bottom: 16px; }
        .section-title { font-size: 14px; font-weight: 700; color: #0c2461; margin: 20px 20px 12px; }
        .card {
            margin: 0 20px 18px;
            border-radius: 28px;
            background: rgba(255,255,255,.34);
            border: 1px solid rgba(255,255,255,.65);
            box-shadow: 0 16px 32px rgba(0,0,0,.08);
            overflow: hidden;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
        }
        .card-header h2 { font-size: 16px; font-weight: 800; color: #1D4ED8; letter-spacing: 0.2px; }
        .btn-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #4f8bff, #1d4ed8);
            color: #ffffff;
            border: none;
            border-radius: 18px;
            padding: 12px 16px;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            box-shadow: 0 14px 32px rgba(29,78,216,.18);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 16px 34px rgba(29,78,216,.24); }
        .passenger-list { padding: 0 18px 20px; }
        .passenger-card {
            background: linear-gradient(180deg, #f7fbff 0%, #eef5ff 100%);
            border-radius: 28px;
            margin-bottom: 14px;
            padding: 20px;
            border: 1px solid rgba(37,99,235,.15);
            box-shadow: 0 18px 40px rgba(37,99,235,.08);
        }
        .passenger-row {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }
        .passenger-label {
            font-size: 11px;
            color: #6b7b9c;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .35px;
            margin-bottom: 6px;
        }
        .passenger-value {
            font-size: 16px;
            color: #152d55;
            font-weight: 800;
            line-height: 1.2;
        }
        .passenger-meta { display: grid; gap: 12px; }
        .passenger-actions {
            display: flex;
            gap: 10px;
            flex-wrap: nowrap;
            justify-content: flex-start;
            margin-top: 18px;
        }
        .action-pill {
            min-width: 120px;
            border: none;
            border-radius: 22px;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 10px 20px rgba(23,75,180,.08);
        }
        .action-pill.edit { background: #e0ecff; color: #2563eb; }
        .action-pill.delete { background: #fee3e3; color: #b91c1c; }
        .action-pill:hover { transform: translateY(-1px); box-shadow: 0 12px 22px rgba(23,75,180,.12); }
        .empty-state {
            margin: 0 20px;
            padding: 32px 18px;
            text-align: center;
            background: rgba(255,255,255,.9);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.9);
            color: rgba(12,36,97,.72);
            font-size: 13px;
            box-shadow: 0 12px 28px rgba(37,99,235,.06);
        }
        .form-modal {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(12,36,97,.35);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 500;
        }
        .form-modal.active { display: flex; }
        .form-card {
            width: 100%; max-width: 360px;
            background: #f9fbff;
            border-radius: 32px;
            padding: 24px 20px;
            box-shadow: 0 30px 70px rgba(0,0,0,.18);
            border: 1px solid rgba(255,255,255,.8);
        }
        .form-card h3 { font-size: 18px; font-weight: 700; color: #0c2461; margin-bottom: 18px; }
        .field-group { margin-bottom: 14px; }
        .field-group label { display: block; font-size: 12px; font-weight: 700; color: rgba(12,36,97,.7); margin-bottom: 6px; }
        .field-group input, .field-group select { width: 100%; border-radius: 16px; border: 1px solid rgba(12,36,97,.12); padding: 12px 14px; font-size: 13px; color: #0c2461; background: white; }
        .field-group input:focus, .field-group select:focus { outline: none; border-color: rgba(37,99,235,.6); }
        .form-actions { display: flex; gap: 12px; margin-top: 18px; }
        .form-actions button { flex: 1; border: none; border-radius: 16px; padding: 14px 0; font-weight: 700; cursor: pointer; transition: transform .2s ease, box-shadow .2s ease; }
        .btn-save { background: #1D4ED8; color: white; }
        .btn-cancel { background: rgba(255,255,255,.92); color: #0c2461; border: 1px solid rgba(12,36,97,.12); }
        .form-actions button:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(0,0,0,.1); }
        .nav-bar {
            position: absolute;
            bottom: 16px;
            left: 14px;
            right: 14px;
            height: 68px;
            border-radius: 26px;
            background: rgba(255,255,255,0.22);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.45);
            box-shadow: 0 8px 32px rgba(30,87,185,0.18), 0 2px 8px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.6);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 12px;
            z-index: 100;
        }
        .nav-item {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 10px 12px;
            border-radius: 16px;
            text-align: center;
            font-size: 10px;
            color: rgba(12,36,97,.45);
            transition: .3s ease;
        }
        .nav-item svg { width: 20px; height: 20px; fill: none; stroke: rgba(12,36,97,.45); stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .nav-item.active { background: rgba(255,255,255,.55); box-shadow: 0 2px 12px rgba(37,99,235,.15); color: #1D4ED8; }
        .nav-item.active svg { stroke: #1D4ED8; }
        a { text-decoration: none; color: inherit; }
        .action-row {
            display: flex;
            justify-content: center;
            margin: 0 20px 18px;
        }

        .action-button {
            width: 100%;
            text-align: center;
            background: rgba(255,255,255,.95);
            color: #1D4ED8;
            border: 1px solid rgba(37,99,235,.3);
            box-shadow: 0 10px 24px rgba(0,0,0,.08);
            padding: 14px 0;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .action-button:hover {
            transform: translateY(-1px);
            background: white;
            box-shadow: 0 14px 28px rgba(0,0,0,.12);
        }

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
        html.dark-mode .passenger-card,
        html.dark-mode .form-card,
        html.dark-mode .booking-card,
        html.dark-mode .form-modal,
        html.dark-mode .action-button {
            background: rgba(15,23,42,.92);
            border-color: rgba(148,163,184,.2);
            color: #e2e8f0;
        }
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .section-title,
        html.dark-mode .passenger-label,
        html.dark-mode .passenger-value,
        html.dark-mode .info-label {
            color: #e2e8f0 !important;
        }
        html.dark-mode input,
        html.dark-mode select {
            background: rgba(15,23,42,.96);
            color: #e2e8f0;
            border-color: rgba(148,163,184,.3);
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
                <h2 class="user-name"><?php echo $name; ?></h2>
                <p class="user-email"><?php echo $email; ?></p>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Data Penumpang Tersimpan</h2>
                    <button class="btn-add" id="openFormBtn">Tambah</button>
                </div>
                <div class="passenger-list" id="passengerList"></div>
                <div class="empty-state" id="emptyState">Belum ada penumpang tersimpan. Tekan tombol Tambah untuk mulai menambahkan.</div>
            </div>
            <div class="action-row">
                <a href="profile.php" class="action-button">Kembali ke Profile</a>
            </div>
        </div>

        <div class="form-modal" id="formModal">
            <div class="form-card">
                <h3 id="formTitle">Tambah Penumpang</h3>
                <div class="field-group">
                    <label for="passengerName">Nama Lengkap</label>
                    <input id="passengerName" type="text" placeholder="Nama penumpang">
                </div>
                <div class="field-group">
                    <label for="passengerPhone">Nomor Telepon</label>
                    <input id="passengerPhone" type="tel" placeholder="Contoh: +62 812-3456-7890">
                </div>
                <div class="field-group">
                    <label for="passengerEmail">Email</label>
                    <input id="passengerEmail" type="email" placeholder="Alamat email">
                </div>
                <div class="field-group">
                    <label for="passengerBirth">Tanggal Lahir</label>
                    <input id="passengerBirth" type="date">
                </div>
                <div class="field-group">
                    <label for="passengerGender">Jenis Kelamin</label>
                    <select id="passengerGender">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" id="cancelForm">Batal</button>
                    <button type="button" class="btn-save" id="saveForm">Simpan</button>
                </div>
            </div>
        </div>

    </div>
    <script src="theme.js"></script>
    <script>
        const STORAGE_KEY = 'savedPassengers';
        const openFormBtn = document.getElementById('openFormBtn');
        const formModal = document.getElementById('formModal');
        const cancelForm = document.getElementById('cancelForm');
        const saveForm = document.getElementById('saveForm');
        const formTitle = document.getElementById('formTitle');
        const passengerList = document.getElementById('passengerList');
        const emptyState = document.getElementById('emptyState');

        const passengerName = document.getElementById('passengerName');
        const passengerPhone = document.getElementById('passengerPhone');
        const passengerEmail = document.getElementById('passengerEmail');
        const passengerBirth = document.getElementById('passengerBirth');
        const passengerGender = document.getElementById('passengerGender');

        let passengers = [];
        let editIndex = null;

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(date);
        }

        function loadPassengers() {
            const stored = window.localStorage.getItem(STORAGE_KEY);
            passengers = stored ? JSON.parse(stored) : [];
            renderPassengers();
        }

        function savePassengers() {
            window.localStorage.setItem(STORAGE_KEY, JSON.stringify(passengers));
            renderPassengers();
        }

        function renderPassengers() {
            passengerList.innerHTML = '';
            if (passengers.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            emptyState.style.display = 'none';

            passengers.forEach((passenger, index) => {
                const card = document.createElement('div');
                card.className = 'passenger-card';
                card.innerHTML = `
                    <div class="passenger-row">
                        <div>
                            <div class="passenger-label">Nama</div>
                            <div class="passenger-value">${passenger.name}</div>
                        </div>
                        <div>
                            <div class="passenger-label">Jenis Kelamin</div>
                            <div class="passenger-value">${passenger.gender || '-'}</div>
                        </div>
                    </div>
                    <div class="passenger-meta">
                        <div class="passenger-row">
                            <div>
                                <div class="passenger-label">Telepon</div>
                                <div class="passenger-value">${passenger.phone || '-'}</div>
                            </div>
                            <div>
                                <div class="passenger-label">Email</div>
                                <div class="passenger-value">${passenger.email || '-'}</div>
                            </div>
                        </div>
                        <div class="passenger-row">
                            <div>
                                <div class="passenger-label">Tanggal Lahir</div>
                                <div class="passenger-value">${formatDate(passenger.birth)}</div>
                            </div>
                        </div>
                    </div>
                    <div class="passenger-actions">
                        <button class="action-pill edit" onclick="openEditForm(${index})">Edit</button>
                        <button class="action-pill delete" onclick="deletePassenger(${index})">Hapus</button>
                    </div>
                `;
                passengerList.appendChild(card);
            });
        }

        function openForm(mode = 'add') {
            formModal.classList.add('active');
            if (mode === 'add') {
                formTitle.textContent = 'Tambah Penumpang';
                editIndex = null;
                passengerName.value = '';
                passengerPhone.value = '';
                passengerEmail.value = '';
                passengerBirth.value = '';
                passengerGender.value = '';
            }
        }

        function closeForm() {
            formModal.classList.remove('active');
        }

        function openEditForm(index) {
            const passenger = passengers[index];
            editIndex = index;
            formTitle.textContent = 'Edit Penumpang';
            passengerName.value = passenger.name;
            passengerPhone.value = passenger.phone;
            passengerEmail.value = passenger.email;
            passengerBirth.value = passenger.birth;
            passengerGender.value = passenger.gender;
            formModal.classList.add('active');
        }

        function deletePassenger(index) {
            if (!confirm('Hapus data penumpang ini?')) return;
            passengers.splice(index, 1);
            savePassengers();
        }

        function validateForm() {
            return passengerName.value.trim() !== '';
        }

        function saveFormHandler() {
            if (!validateForm()) {
                alert('Mohon isi nama penumpang terlebih dahulu.');
                passengerName.focus();
                return;
            }

            const record = {
                name: passengerName.value.trim(),
                phone: passengerPhone.value.trim(),
                email: passengerEmail.value.trim(),
                birth: passengerBirth.value,
                gender: passengerGender.value,
            };

            if (editIndex !== null) {
                passengers[editIndex] = record;
            } else {
                passengers.push(record);
            }

            savePassengers();
            closeForm();
        }

        openFormBtn.addEventListener('click', () => openForm('add'));
        cancelForm.addEventListener('click', closeForm);
        formModal.addEventListener('click', (event) => {
            if (event.target === formModal) closeForm();
        });
        saveForm.addEventListener('click', saveFormHandler);

        loadPassengers();
    </script>
</body>
</html>
