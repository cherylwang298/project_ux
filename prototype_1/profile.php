<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Profile Page</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #cbd5e1; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* =========================
           PHONE FRAME (Smooth Gradient Blue to White)
        ========================== */
        .phone-frame {
            width: 375px; 
            height: 812px; 
            border-radius: 45px; 
            border: 10px solid #111; 
            position: relative;
            
            background: linear-gradient(
                180deg,
                #93C6F9 0%,
                #C2E0FD 25%,
                #EAF4FF 50%,
                #FFFFFF 100%
            );
            overflow: hidden; 
            display: flex;
            flex-direction: column;
            box-shadow: 0 35px 70px rgba(0, 0, 0, .30), inset 0 0 0 1px rgba(255, 255, 255, .08);
        }

        .phone-notch {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 110px;
            height: 28px;
            background: #111;
            border-radius: 20px;
            z-index: 1000;
        }

        /* =========================
           ANIMATED BLOBS
        ========================== */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(8px);
            opacity: 0.6; 
            z-index: 0;
        }
        .blob-top {
            width: 420px;
            height: 420px;
            background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0.2));
            top: -150px;
            right: -100px;
            animation: blobMove 10s ease-in-out infinite;
        }

        @keyframes blobMove {
            0%, 100% { transform: rotate(0deg) scale(1); border-radius: 42% 58% 63% 37% / 45% 40% 60% 55%; }
            50% { transform: rotate(10deg) scale(1.05); border-radius: 58% 42% 37% 63% / 50% 60% 40% 50%; }
        }

        /* =========================
           CONTENT AREA
        ========================== */
        .content-area {
            flex: 1;
            overflow-y: auto; 
            scrollbar-width: none; 
            padding-bottom: 120px; 
            position: relative;
            z-index: 10;
        }
        .content-area::-webkit-scrollbar { display: none; }

        /* =========================
           PROFILE HEADER - Glassmorphism
        ========================== */
        .profile-header {
            margin: 70px 20px 20px;
            padding: 24px 20px;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(120, 170, 220, 0.15);
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
            width: 86px;
            height: 86px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.9);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background-color: white; /* Biar pinggirannya bersih */
        }

        .edit-avatar-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #16324f;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            border: 2px solid white;
            cursor: pointer;
        }

        .user-name {
            font-size: 20px;
            font-weight: 700;
            color: #16324f;
            margin-bottom: 4px;
        }

        .user-email {
            font-size: 13px;
            font-weight: 500;
            color: rgba(22,50,79,0.7);
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
            background: rgba(255, 255, 255, 0.6);
            padding: 12px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.8);
        }

        .stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #AEE2FF;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .stat-label {
            font-size: 10px;
            font-weight: 600;
            color: #16324f;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* =========================
           MENU LIST - Glassmorphism
        ========================== */
        .menu-section {
            margin: 0 20px 24px;
        }

        .menu-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #16324f;
            margin-bottom: 12px;
            padding-left: 8px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        .menu-item-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-icon {
            font-size: 20px;
            background: rgba(147, 198, 249, 0.3);
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
        }

        .menu-text {
            font-size: 14px;
            font-weight: 500;
            color: #16324f;
        }

        .menu-arrow {
            font-size: 14px;
            color: #7DA0C4;
        }

        .logout-text {
            color: #e63946;
            font-weight: 600;
        }
        
        .logout-icon {
            background: rgba(230, 57, 70, 0.1);
        }

        /* =========================
           FLOATING GLASS NAVBAR
        ========================== */
        .nav-bar {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: 24px;
            height: 74px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.1);
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
            color: #16324f;
            font-weight: 600;
            transform: translateY(-2px);
            background: rgba(147, 198, 249, 0.2);
        }

        .nav-icon { font-size: 20px; }

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
                            <div class="menu-icon">👤</div>
                            <span class="menu-text">Informasi Pribadi</span>
                        </div>
                        <div class="menu-arrow">❯</div>
                    </a>

                    <div class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">📝</div>
                            <span class="menu-text">Data Penumpang Tersimpan</span>
                        </div>
                        <div class="menu-arrow">❯</div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">💳</div>
                            <span class="menu-text">Metode Pembayaran</span>
                        </div>
                        <div class="menu-arrow">❯</div>
                    </div>
                </div>
            </div>

            <div class="menu-section">
                <h3 class="menu-section-title">Pengaturan & Bantuan</h3>
                <div class="menu-card">
                    <div class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">⚙️</div>
                            <span class="menu-text">Pengaturan Aplikasi</span>
                        </div>
                        <div class="menu-arrow">❯</div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon">🎧</div>
                            <span class="menu-text">Pusat Bantuan</span>
                        </div>
                        <div class="menu-arrow">❯</div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-item-left">
                            <div class="menu-icon logout-icon">🚪</div>
                            <span class="menu-text logout-text">Keluar (Log Out)</span>
                        </div>
                        <div class="menu-arrow"></div>
                    </div>
                </div>
            </div>

        </div>

        <nav class="nav-bar">
            <div class="nav-item">
                <a href="home.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <span class="nav-icon">🏠</span>
                    <span>Awal</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="explore.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <span class="nav-icon">🔍</span>
                    <span>Explore</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="pesanan.php" style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <span class="nav-icon">📅</span>
                    <span>Pesanan</span>
                </a>
            </div>
            <div class="nav-item active">
                <span class="nav-icon">👤</span>
                <span>Profil</span>
            </div>
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
</body>
</html>