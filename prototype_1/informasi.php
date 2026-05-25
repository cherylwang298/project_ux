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
$phone = get_user_value('phone', '+62 812-3456-7890');
$birth = get_user_value('birth', '16 Mei 1994');
$address = get_user_value('address', 'Surabaya, Indonesia');
$role = get_user_value('role', 'Pengguna');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pribadi</title>
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

        .header-card {
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

        .role-tag {
            font-size: 11px;
            font-weight: 700;
            background: rgba(37,99,235,.15);
            color: #1D4ED8;
            padding: 8px 14px;
            border-radius: 999px;
            letter-spacing: .4px;
        }

        .info-section {
            margin: 0 20px 24px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #0c2461;
            margin-bottom: 14px;
            padding-left: 8px;
        }

        .info-card {
            background: rgba(255,255,255,.42);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 10px 26px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255,255,255,.65);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 13px;
            font-weight: 600;
            color: #0c2461;
            max-width: 45%;
        }

        .info-value {
            font-size: 13px;
            font-weight: 500;
            color: rgba(12,36,97,.82);
            text-align: right;
            word-break: break-word;
            max-width: 55%;
        }

        .action-row {
            display: flex;
            justify-content: center;
            margin: 0 20px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0 20px 18px;
            padding: 12px 14px;
            border-radius: 20px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(37,99,235,.18);
            color: #1D4ED8;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 12px 24px rgba(29,78,216,.12);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .back-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(29,78,216,.16);
        }
        .back-button span.arrow {
            font-size: 18px;
            line-height: 1;
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

        a { text-decoration: none; color: inherit; }

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
        html.dark-mode .info-card,
        html.dark-mode .back-button {
            background: rgba(15,23,42,.92);
            border-color: rgba(148,163,184,.2);
            color: #e2e8f0;
        }
        html.dark-mode .info-label,
        html.dark-mode .info-value,
        html.dark-mode .user-name,
        html.dark-mode .user-email,
        html.dark-mode .section-title {
            color: #e2e8f0 !important;
        }
        html.dark-mode .back-button {
            background: rgba(31,41,55,.9);
            color: #bfdbfe;
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
                <span class="role-tag"><?php echo $role; ?></span>
            </div>

            <div class="info-section">
                <h3 class="section-title">Informasi Pribadi</h3>
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-label">Nama Lengkap</span>
                        <span class="info-value"><?php echo $name; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?php echo $email; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nomor Telepon</span>
                        <span class="info-value"><?php echo $phone; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Lahir</span>
                        <span class="info-value"><?php echo $birth; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-value"><?php echo $address; ?></span>
                    </div>
                </div>
            </div>

            <div class="action-row">
                <a href="profile.php" class="action-button">Kembali ke Profile</a>
            </div>
        </div>
    </div>
    <script src="theme.js"></script>
</body>
</html>
