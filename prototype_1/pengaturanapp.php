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
$email = get_user_value('email', 'c14240045@john.petra.ac.id');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Aplikasi</title>
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
            transition: background .3s ease, color .3s ease;
        }
        .phone-frame {
            width: 375px;
            min-height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: linear-gradient(165deg, #1e57b8 0%, #2563eb 18%, #4a90d9 36%, #82b8f0 54%, #c5deff 72%, #ebf4ff 88%, #f5f9ff 100%);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
            transition: background .3s ease, box-shadow .3s ease, border .3s ease;
        }
        .dark-mode body {
            background: #111827;
            color: #e2e8f0;
        }
        .dark-mode .phone-frame {
            border-color: #0f172a;
            background: linear-gradient(165deg, #0f172a 0%, #111827 25%, #1f2937 55%, #111827 85%, #0f172a 100%);
            box-shadow: 0 40px 80px rgba(0,0,0,.7), inset 0 0 0 1px rgba(255,255,255,.08);
        }
        .dark-mode .content-area {
            color: #e2e8f0;
        }
        .dark-mode .header-card,
        .dark-mode .settings-card,
        .dark-mode .back-link {
            background: rgba(15,23,42,.85);
            border-color: rgba(148,163,184,.2);
            box-shadow: 0 12px 30px rgba(0,0,0,.45);
        }
        .dark-mode .page-title,
        .dark-mode .setting-title,
        .dark-mode .back-link {
            color: #f8fafc;
        }
        .dark-mode .page-desc,
        .dark-mode .setting-description,
        .dark-mode select {
            color: #cbd5e1;
        }
        .dark-mode .setting-row {
            border-color: rgba(148,163,184,.15);
        }
        .dark-mode select {
            background: #0f172a;
            border-color: rgba(148,163,184,.3);
        }
        .dark-mode .toggle {
            background: rgba(255,255,255,.08);
            border-color: rgba(148,163,184,.3);
        }
        .dark-mode .toggle.active {
            background: #2563eb;
        }
        .dark-mode .toggle-handle {
            background: #f8fafc;
        }
        .dark-mode .back-link {
            color: #bfdbfe;
        }
        .phone-notch {
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 26px;
            background: #18181b;
            border-radius: 14px;
            z-index: 500;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .blob-top {
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255,255,255,.22) 0%, transparent 70%);
            top: -80px;
            right: -80px;
            opacity: .7;
        }
        .content-area {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
            padding-bottom: 120px;
            position: relative;
            z-index: 10;
        }
        .content-area::-webkit-scrollbar { display: none; }
        .header-card {
            margin: 28px 20px 16px;
            padding: 22px 20px;
            background: rgba(255,255,255,.42);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 14px 30px rgba(0,0,0,.12);
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #1D4ED8;
        }
        .page-desc {
            font-size: 13px;
            color: rgba(12,36,97,.72);
            line-height: 1.6;
        }
        .settings-card {
            margin: 0 20px 18px;
            padding: 20px;
            background: rgba(255,255,255,.82);
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 16px 32px rgba(0,0,0,.08);
            backdrop-filter: blur(18px);
        }
        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid rgba(15,23,42,.08);
        }
        .setting-row:last-child { border-bottom: none; }
        .setting-label {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .setting-title {
            font-size: 14px;
            font-weight: 700;
            color: #0c2461;
        }
        .setting-description {
            font-size: 12px;
            color: rgba(12,36,97,.65);
            max-width: 220px;
        }
        .toggle {
            width: 46px;
            height: 26px;
            border-radius: 999px;
            background: #dbeafe;
            position: relative;
            cursor: pointer;
            border: 1px solid rgba(37,99,235,.16);
            flex-shrink: 0;
        }
        .toggle-handle {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #fff;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform .2s ease, background .2s ease;
            box-shadow: 0 8px 16px rgba(15,23,42,.12);
        }
        .toggle.active {
            background: #1d4ed8;
        }
        .toggle.active .toggle-handle {
            transform: translateX(20px);
            background: #fff;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0 20px 18px;
            padding: 12px 14px;
            border-radius: 20px;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(37,99,235,.18);
            color: #1D4ED8;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 12px 24px rgba(29,78,216,.12);
        }
        .back-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(29,78,216,.16);
        }

        html.dark-mode body {
            background: #020617;
            color: #e2e8f0;
        }
        html.dark-mode .phone-frame {
            border-color: #0f172a;
            background: linear-gradient(165deg, #0f172a 0%, #111827 30%, #1f2937 60%, #0f172a 100%);
        }
        html.dark-mode .header-card,
        html.dark-mode .settings-card,
        html.dark-mode .back-link {
            background: rgba(15,23,42,.92);
            border-color: rgba(148,163,184,.2);
            color: #e2e8f0;
        }
        html.dark-mode .page-title,
        html.dark-mode .page-desc,
        html.dark-mode .setting-title,
        html.dark-mode .setting-description,
        html.dark-mode .back-link {
            color: #e2e8f0 !important;
        }
        html.dark-mode select {
            background: rgba(15,23,42,.96);
            color: #e2e8f0;
            border-color: rgba(148,163,184,.3);
        }
        html.dark-mode .toggle {
            background: rgba(255,255,255,.08);
            border-color: rgba(148,163,184,.3);
        }
        html.dark-mode .toggle.active {
            background: #2563eb;
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
        html.dark-mode .header-card,
        html.dark-mode .settings-card,
        html.dark-mode .back-link {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .page-title,
        html.dark-mode .page-desc,
        html.dark-mode .setting-title,
        html.dark-mode .setting-description,
        html.dark-mode .back-link {
            color: #e2e8f0 !important;
        }
        html.dark-mode select {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
        html.dark-mode .toggle {
            background: rgba(255,255,255,.08) !important;
            border-color: rgba(148,163,184,.3) !important;
        }
        html.dark-mode .toggle.active {
            background: #2563eb !important;
        }
    </style>
</head>
<body>
    <div class="phone-frame">
        <div class="phone-notch"></div>
        <div class="blob blob-top"></div>
        <div class="content-area">
            <div class="header-card">
                <div class="page-title">Pengaturan Aplikasi</div>
                <div class="page-desc">Atur notifikasi, tampilan, dan preferensi aplikasi kamu. Semua pengaturan ini hanya tersimpan di perangkat.</div>
            </div>
            <div class="settings-card">
                <div class="setting-row">
                    <div class="setting-label">
                        <span class="setting-title">Notifikasi</span>
                        <span class="setting-description">Terima pemberitahuan tentang promo dan status pemesanan.</span>
                    </div>
                    <button class="toggle" id="notifToggle" type="button">
                        <span class="toggle-handle"></span>
                    </button>
                </div>
                <div class="setting-row">
                    <div class="setting-label">
                        <span class="setting-title">Tema Gelap</span>
                        <span class="setting-description">Aktifkan mode gelap untuk tampilan yang lebih nyaman malam hari.</span>
                    </div>
                    <button class="toggle" id="darkToggle" type="button">
                        <span class="toggle-handle"></span>
                    </button>
                </div>
                <div class="setting-row">
                    <div class="setting-label">
                        <span class="setting-title">Bahasa Aplikasi</span>
                        <span class="setting-description">Pilih bahasa yang digunakan di aplikasi.</span>
                    </div>
                    <select id="languageSelect" style="border-radius:12px; border:1px solid rgba(12,36,97,.18); padding:10px 12px; font-size:13px; color:#0c2461; background:#fff;">
                        <option value="id">Bahasa Indonesia</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <div class="setting-row">
                    <div class="setting-label">
                        <span class="setting-title">Pembayaran Otomatis</span>
                        <span class="setting-description">Simpan preferensi pembayaran untuk checkout lebih cepat.</span>
                    </div>
                    <button class="toggle" id="autoPayToggle" type="button">
                        <span class="toggle-handle"></span>
                    </button>
                </div>
            </div>
            <a href="profile.php" class="back-link">
                <span class="arrow">&lt;</span>
                <span>Kembali ke Profil</span>
            </a>
        </div>
    </div>
    <script>
        const darkToggle = document.getElementById('darkToggle');
        const notifToggle = document.getElementById('notifToggle');
        const autoPayToggle = document.getElementById('autoPayToggle');
        const languageSelect = document.getElementById('languageSelect');

        function setPref(key, value) {
            window.localStorage.setItem(key, value);
        }

        function getPref(key, defaultValue) {
            return window.localStorage.getItem(key) ?? defaultValue;
        }

        function applyDarkMode(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                darkToggle.classList.add('active');
            } else {
                document.documentElement.classList.remove('dark-mode');
                darkToggle.classList.remove('active');
            }
        }

        function applyToggleState(toggle, state) {
            if (state === 'on') {
                toggle.classList.add('active');
            } else {
                toggle.classList.remove('active');
            }
        }

        darkToggle.addEventListener('click', () => {
            const nextState = darkToggle.classList.contains('active') ? 'off' : 'on';
            applyDarkMode(nextState === 'on');
            setPref('themeDark', nextState);
        });

        notifToggle.addEventListener('click', () => {
            const nextState = notifToggle.classList.contains('active') ? 'off' : 'on';
            applyToggleState(notifToggle, nextState);
            setPref('notifEnabled', nextState);
        });

        autoPayToggle.addEventListener('click', () => {
            const nextState = autoPayToggle.classList.contains('active') ? 'off' : 'on';
            applyToggleState(autoPayToggle, nextState);
            setPref('autoPayEnabled', nextState);
        });

        languageSelect.addEventListener('change', () => {
            setPref('appLanguage', languageSelect.value);
        });

        const savedDark = getPref('themeDark', 'off');
        applyDarkMode(savedDark === 'on');

        const savedNotif = getPref('notifEnabled', 'off');
        applyToggleState(notifToggle, savedNotif);

        const savedAutoPay = getPref('autoPayEnabled', 'off');
        applyToggleState(autoPayToggle, savedAutoPay);

        const savedLang = getPref('appLanguage', 'id');
        languageSelect.value = savedLang;
    </script>
    <script src="theme.js"></script>
</body>
</html>
