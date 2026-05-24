<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agoda Redesign - Edit Profil</title>
    
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
            background: linear-gradient(180deg, #93C6F9 0%, #C2E0FD 25%, #EAF4FF 50%, #FFFFFF 100%);
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

        /* ANIMATED BLOBS */
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
            padding: 70px 24px 40px; 
            position: relative;
            z-index: 10;
        }

        /* HEADER DENGAN TOMBOL BACK */
        .header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.8);
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #16324f;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: #16324f;
        }

        /* FORM EDIT */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #16324f;
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            border: 1px solid rgba(22,50,79,0.1);
            font-size: 14px;
            color: #16324f;
            outline: none;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            transition: 0.3s;
        }

        .form-input:focus {
            background: rgba(255,255,255,0.9);
            border-color: #7DA0C4;
        }

        /* Input yang di-disable (buat email karena gabisa diganti) */
        .form-input:disabled {
            background: rgba(255, 255, 255, 0.3);
            color: rgba(22,50,79,0.5);
        }

        /* SAVE BUTTON */
        .save-btn {
            width: 100%;
            padding: 16px;
            border-radius: 18px;
            border: none;
            background: #16324f;
            font-size: 15px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(22,50,79,0.2);
            margin-top: 20px;
            transition: 0.3s;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(22,50,79,0.3);
        }

    </style>
</head>
<body>

    <div class="phone-frame">
        <div class="phone-notch"></div> 
        <div class="blob blob-top"></div>
        
        <div class="content-area">
            <div class="header-top">
                <a href="profile.php" class="back-btn">←</a>
                <h1 class="page-title">Edit Profil</h1>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Tampilan</label>
                <input type="text" id="input-name" class="form-input" value="Jessica Gabriel">
            </div>

            <div class="form-group">
                <label class="form-label">Email Aktif</label>
                <input type="email" class="form-input" value="c14240045@john.petra.ac.id" disabled>
            </div>

            <button class="save-btn" onclick="saveProfile()">Simpan Perubahan</button>
        </div>
    </div>

    <script>
        // Cek kalau udah pernah ngedit nama, taruh nama yang baru di dalem input
        window.onload = () => {
            const savedName = localStorage.getItem('agoda_user_name');
            if(savedName) {
                document.getElementById('input-name').value = savedName;
            }
        }

        function saveProfile() {
            // Ambil nama dari kotak input
            const newName = document.getElementById('input-name').value;
            
            // Simpan ke local storage biar browser hafal
            localStorage.setItem('agoda_user_name', newName);
            
            // Habis disave, otomatis balik ke halaman profil
            window.location.href = 'profile.php';
        }
    </script>
</body>
</html>