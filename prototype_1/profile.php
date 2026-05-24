<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Profile Page</title>
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: #b8cfe8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 16px;
        }

        .phone-frame {
            width: 375px;
            height: 812px;
            border-radius: 44px;
            border: 9px solid #18181b;
            position: relative;
            background: linear-gradient(165deg,
                #1e57b8 0%,
                #2563eb 18%,
                #4a90d9 36%,
                #82b8f0 54%,
                #c5deff 72%,
                #ebf4ff 88%,
                #f5f9ff 100%
            );
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), inset 0 0 0 1px rgba(255,255,255,.12);
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

        .profile-header {
            margin: 68px 20px 20px;
            padding: 24px 20px;
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

        .avatar-container {
            position: relative;
            margin-bottom: 16px;
        }

        .avatar-img {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,.95);
            box-shadow: 0 10px 24px rgba(0,0,0,.12);
            border: 3px solid rgba(255,255,255,0.9);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background-color: white; /* Biar pinggirannya bersih */
        }

        .edit-avatar-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #ffffff;
            color: #1d4ed8;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            border: 2px solid rgba(37,99,235,.18);
            cursor: pointer;
        }

        .user-name {
            font-size: 22px;
            font-weight: 700;
            color: #0c2461;
            margin-bottom: 4px;
            font-family: 'Playfair Display', serif;
        }

        .user-email {
            font-size: 13px;
            font-weight: 500;
            color: rgba(12,36,97,.72);
            margin-bottom: 16px;
        }

        .stats-row {
            display: flex;
            width: 100%;
            justify-content: center;
            gap: 12px;
        }

        .stat-box {
            flex: 1;
            background: rgba(255,255,255,.55);
            padding: 14px 12px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.82);
        }

        .stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #1D4ED8;
        }

        .stat-label {
            font-size: 10px;
            font-weight: 600;
            color: #0c2461;
            text-transform: uppercase;
            margin-top: 5px;
            letter-spacing: .4px;
        }

        .menu-section {
            margin: 0 20px 24px;
        }

        .menu-section-title {
            font-size: 14px;
            font-weight: 700;
            color: #0c2461;
            margin-bottom: 12px;
            padding-left: 8px;
        }

        .menu-card {
            background: rgba(255,255,255,.42);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 10px 26px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            cursor: pointer;
            transition: background 0.2s ease;
            text-decoration: none; /* Penting untuk tag a */
        }

        .menu-item:not(:last-child) {
            border-bottom: 1px solid rgba(255,255,255,.65);
        }

        .menu-item:hover {
            background: rgba(255,255,255,.8);
            transform: translateY(-1px);
        }

        .menu-item-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-icon {
            font-size: 20px;
            width: 42px;
            height: 42px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 14px;
            background: rgba(37,99,235,.14);
            color: #1D4ED8;
        }

        .menu-text {
            font-size: 14px;
            font-weight: 500;
            color: #0c2461;
        }

        .menu-arrow {
            font-size: 14px;
            color: rgba(12,36,97,.6);
        }

        .logout-text {
            color: #e63946;
            font-weight: 700;
        }
        
        .logout-icon {
            background: rgba(230,57,70,.12);
            color: #e63946;
        }

        /* .nav-bar {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: 24px;
            height: 74px;
            border-radius: 28px;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255,255,255,.9);
            box-shadow: 0 20px 45px rgba(0,0,0,.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 100;
        }
        
        a { text-decoration: none; color: inherit; }
        
        .nav-item {
            color: #7DA0C4;
            transition: .3s;
            padding: 10px 14px;
            border-radius: 18px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 10px;
        }

        .nav-item.active {
            color: #1D4ED8;
            font-weight: 700;
            transform: translateY(-2px);
            background: rgba(37,99,235,.18);
        }

        .nav-icon { font-size: 20px; } */

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

    box-shadow:
        0 8px 32px rgba(30,87,185,0.18),
        0 2px 8px rgba(0,0,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.6);

    display: flex;
    justify-content: space-around;
    align-items: center;

    padding: 0 12px;
    z-index: 100;
}

a {
    text-decoration: none;
    color: inherit;
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

.nav-item svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: rgba(12,36,97,.45);
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.nav-item.active {
    background: rgba(255,255,255,.55);
    box-shadow: 0 2px 12px rgba(37,99,235,.15);
    color: #1D4ED8;
}

.nav-item.active svg {
    stroke: #1D4ED8;
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
        html.dark-mode .profile-header,
        html.dark-mode .menu-card,
        html.dark-mode .stat-box,
        html.dark-mode .menu-item,
        html.dark-mode .nav-bar {
            background: rgba(15,23,42,.92);
            border-color: rgba(148,163,184,.2);
            color: #e2e8f0;
        }
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .menu-text,
        html.dark-mode .menu-section-title,
        html.dark-mode .stat-value,
        html.dark-mode .stat-label {
            color: #e2e8f0 !important;
        }
        html.dark-mode .menu-item:hover {
            background: rgba(37,99,235,.15);
        }
        html.dark-mode .menu-icon {
            background: rgba(37,99,235,.2);
            color: #bfdbfe;
        }
        html.dark-mode .logout-text,
        html.dark-mode .logout-icon {
            color: #fca5a5;
        }
        html.dark-mode .nav-item {
            background: rgba(15,23,42,.8);
            color: #94a3b8;
        }
        html.dark-mode .nav-item.active {
            background: rgba(37,99,235,.95);
            color: white;
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
        html.dark-mode .profile-header,
        html.dark-mode .menu-card,
        html.dark-mode .stat-box,
        html.dark-mode .menu-item,
        html.dark-mode .nav-bar,
        html.dark-mode .action-button,
        html.dark-mode .back-link,
        html.dark-mode .info-card,
        html.dark-mode .booking-card,
        html.dark-mode .form-card,
        html.dark-mode .settings-card {
            background: rgba(15,23,42,.92) !important;
            border-color: rgba(148,163,184,.2) !important;
            color: #e2e8f0 !important;
        }
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .menu-text,
        html.dark-mode .menu-section-title,
        html.dark-mode .stat-value,
        html.dark-mode .stat-label,
        html.dark-mode .section-title,
        html.dark-mode .info-label,
        html.dark-mode .info-value {
            color: #e2e8f0 !important;
        }
        html.dark-mode .menu-icon {
            background: rgba(37,99,235,.2) !important;
            color: #bfdbfe !important;
        }
        html.dark-mode .menu-item:hover {
            background: rgba(37,99,235,.12) !important;
        }
        html.dark-mode .nav-item {
            background: rgba(15,23,42,.9) !important;
            color: #94a3b8 !important;
        }
        html.dark-mode .nav-item.active {
            background: rgba(37,99,235,.95) !important;
            color: white !important;
        }
        html.dark-mode input,
        html.dark-mode select,
        html.dark-mode textarea {
            background: rgba(15,23,42,.96) !important;
            color: #e2e8f0 !important;
            border-color: rgba(148,163,184,.3) !important;
        }
        html.dark-mode .phone-notch,
        html.dark-mode .notch {
            background: #0f172a !important;
        }
        html.dark-mode .blob-top,
        html.dark-mode .blob-1,
        html.dark-mode .blob-2,
        html.dark-mode .blob-bottom,
        html.dark-mode .bg-glow {
            opacity: .35 !important;
        }
    </style>
</head>
<body>

    <div class="phone-frame">
        <div class="phone-notch"></div> 
        <div class="blob blob-top"></div>
        
        <div class="content-area">

            <div class="profile-header">
                <div class="avatar-container">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="Profile" class="avatar-img">
                    <div class="edit-avatar-btn">✏️</div>
                </div>
                <h2 class="user-name" id="display-name">Jessica Gabriel</h2>
                <p class="user-email">c14240045@john.petra.ac.id</p>
                
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-value">1.250</div>
                        <div class="stat-label">AgodaCash</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">4</div>
                        <div class="stat-label">Pesanan</div>
                    </div>
                </div>
            </div>

            <div class="menu-section">
                <h3 class="menu-section-title">Akun Saya</h3>
                <div class="menu-card">
                    
                <a href="edit_profile.php" class="menu-item">
    <div class="menu-item-left">
        <div class="menu-icon">
           <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="3.5" />
                                    <path d="M5.5 20.5c0-3.5 2.9-6.5 6.5-6.5s6.5 3 6.5 6.5" />
                                </svg>
        </div>
        <span class="menu-text">Informasi Pribadi</span>
    </div>

    <div class="menu-arrow">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
              stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
        </svg>
    </div>
</a>

                    
                    <div class="menu-item">
                    <a href="informasi.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="3.5" />
                                    <path d="M5.5 20.5c0-3.5 2.9-6.5 6.5-6.5s6.5 3 6.5 6.5" />
                                </svg>
                            </div>
                            <span class="menu-text">Informasi Pribadi</span>
                        </div>
                        <div class="menu-arrow">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                    <a href="datapenumpang.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 3h10a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                    <path d="M9 7h6" />
                                    <path d="M9 11h6" />
                                    <path d="M9 15h4" />
                                </svg>
                            </div>
                            <span class="menu-text">Data Penumpang Tersimpan</span>
                        </div>
                        <div class="menu-arrow">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                    <a href="metodepembayaran.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="7" width="18" height="10" rx="2" />
                                    <path d="M3 11h18" />
                                    <path d="M7 7v-1" />
                                    <path d="M17 7v-1" />
                                </svg>
                            </div>
                            <span class="menu-text">Metode Pembayaran</span>
                        </div>
                        <div class="menu-arrow">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <div class="menu-section">
                <h3 class="menu-section-title">Pengaturan & Bantuan</h3>
                <div class="menu-card">
                    <a href="pengaturanapp.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z" />
                                </svg>
                            </div>
                            <span class="menu-text">Pengaturan Aplikasi</span>
                        </div>
                        <div class="menu-arrow">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                    <a href="pusatbantuan.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 15v-3a8 8 0 0 1 16 0v3" />
                                    <path d="M8 15v5a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-5" />
                                </svg>
                            </div>
                            <span class="menu-text">Pusat Bantuan</span>
                        </div>
                        <div class="menu-arrow">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                    <a href="login.php" class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon logout-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <path d="M16 17l5-5-5-5" />
                                    <path d="M21 12H9" />
                                </svg>
                            </div>
                            <span class="menu-text logout-text">Keluar (Log Out)</span>
                        </div>
                        <div class="menu-arrow"></div>
                    </a>
                </div>
            </div>

        </div>

        <nav class="nav-bar">
    <a href="home.php" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5Z"/>
            <path d="M9 21V12h6v9"/>
        </svg>
        <span>Awal</span>
    </a>

    <a href="explore.php" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
        </svg>
        <span>Explore</span>
    </a>

    <a href="pesanan.php" class="nav-item">
        <svg class="nav-icon" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <path d="M16 2v4"/>
            <path d="M8 2v4"/>
            <path d="M3 10h18"/>
        </svg>
        <span>Pesanan</span>
    </a>

    <a href="profile.php" class="nav-item active">
        <svg class="nav-icon" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Profil</span>
    </a>
</nav>
    </div>

    <script>
        window.onload = () => {
            const savedName = localStorage.getItem('agoda_user_name');
            if(savedName) {
                document.getElementById('display-name').innerText = savedName;
            }
        }
    </script>
    <script src="theme.js"></script>
</body>
</html>