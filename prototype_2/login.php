<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['logged_in'])) { header('Location: home.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    // Accept any non-empty credentials (demo app)
    if ($user !== '' && $pass !== '') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $user;
        $_SESSION['email']     = strtolower(str_replace(' ','.',trim($user))).'@voyage.id';
        $_SESSION['avatar']    = 'https://ui-avatars.com/api/?name='.urlencode($user).'&background=003082&color=fff&size=128';
        header('Location: home.php'); exit;
    } else {
        $error = 'Username dan password wajib diisi.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Login – Sriwijaya Voyage</title>
<style>
:root{--primary:#003082;--accent:#E8151B;}
*{margin:0;padding:0;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;}
body{background:#fff;min-height:100vh;}
.hero{position:relative;height:38vh;overflow:hidden;}
.hero img{width:100%;height:100%;object-fit:cover;}
.hero-overlay{position:absolute;inset:0;background:rgba(0,32,130,.5);}
.back-btn{position:absolute;top:20px;left:20px;width:38px;height:38px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;cursor:pointer;text-decoration:none;}
.brand{position:absolute;bottom:24px;left:24px;color:#fff;}
.brand h1{font-size:22px;font-weight:800;}
.brand p{font-size:13px;opacity:.85;}
.sheet{background:#fff;border-radius:28px 28px 0 0;padding:28px 24px 40px;margin-top:-20px;position:relative;}
.sheet h2{font-size:22px;font-weight:700;margin-bottom:4px;}
.sheet .sub{color:#6B7280;font-size:14px;margin-bottom:28px;}
.input-group{margin-bottom:16px;}
.input-group label{display:block;font-size:12px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;}
.input-group input{width:100%;padding:14px 16px;border:1.5px solid #E5E7EB;border-radius:14px;font-size:15px;outline:none;background:#fff;}
.input-group input:focus{border-color:var(--primary);}
.hint{font-size:11px;color:#9CA3AF;margin-top:4px;}
.btn{display:block;width:100%;padding:15px;border:none;border-radius:40px;font-size:16px;font-weight:700;cursor:pointer;text-align:center;margin-bottom:14px;}
.btn-primary{background:var(--primary);color:#fff;}
.btn-outline{background:#fff;color:var(--primary);border:2.5px solid var(--primary);}
.error{background:#FEE2E2;color:var(--accent);padding:12px 16px;border-radius:14px;font-size:13px;margin-bottom:16px;}
.demo-hint{background:#EEF2FF;border-radius:14px;padding:12px 16px;font-size:12px;color:#4338CA;margin-bottom:20px;}
</style>
</head>
<body>
<div class="hero">
  <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&q=80" alt="Plane">
  <div class="hero-overlay"></div>
  <a href="index.php" class="back-btn">←</a>
  <div class="brand">
    <h1>✈️ Sriwijaya Voyage</h1>
    <p>Selamat datang kembali!</p>
  </div>
</div>

<div class="sheet">
  <h2>Masuk ke Akun</h2>
  <p class="sub">Lanjutkan perjalanan impianmu.</p>

  <?php if ($error): ?>
  <div class="error">⚠️ <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="demo-hint">💡 <strong>Demo:</strong> Isi nama & password apa saja untuk masuk.</div>

  <form method="POST">
    <div class="input-group">
      <label>Username / Email</label>
      <input type="text" name="username" placeholder="Contoh: Budi Santoso" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="Password kamu" autocomplete="current-password">
    </div>
    <button type="submit" class="btn btn-primary">Masuk</button>
  </form>
  <a href="index.php" class="btn btn-outline">Kembali</a>
</div>
</body>
</html>