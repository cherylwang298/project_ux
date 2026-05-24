<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['logged_in'])) { header('Location: home.php'); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Sriwijaya Voyage – Login</title>
<style>
:root{--primary:#003082;--accent:#E8151B;}
*{margin:0;padding:0;box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;}
body{background:#fff;min-height:100vh;display:flex;flex-direction:column;}
.hero{position:relative;height:52vh;overflow:hidden;}
.hero img{width:100%;height:100%;object-fit:cover;}
.hero-overlay{position:absolute;inset:0;background:rgba(0,32,130,.55);}
.hero-brand{position:absolute;bottom:32px;left:24px;color:#fff;}
.hero-brand .logo-row{display:flex;align-items:center;gap:10px;margin-bottom:6px;}
.hero-brand .logo-circle{width:44px;height:44px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;}
.hero-brand h1{font-size:26px;font-weight:800;letter-spacing:-.5px;}
.hero-brand p{font-size:14px;opacity:.85;margin-top:2px;}
.content{flex:1;padding:28px 24px 40px;background:#fff;border-radius:28px 28px 0 0;margin-top:-20px;position:relative;}
.content h2{font-size:22px;font-weight:700;color:#111827;margin-bottom:4px;}
.content p{color:#6B7280;font-size:14px;margin-bottom:28px;}
.btn{display:block;width:100%;padding:15px;border:none;border-radius:40px;font-size:16px;font-weight:700;cursor:pointer;text-align:center;margin-bottom:14px;transition:.15s;}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:#002060;}
.btn-outline{background:#fff;color:var(--primary);border:2.5px solid var(--primary);}
/* Modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;justify-content:center;align-items:flex-end;}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:28px 28px 0 0;padding:32px 24px 44px;width:100%;max-width:500px;text-align:center;}
.modal-box .icon{font-size:56px;margin-bottom:12px;}
.modal-box h3{font-size:20px;font-weight:700;margin-bottom:6px;}
.modal-box p{color:#6B7280;font-size:14px;margin-bottom:24px;}
/* Signup form */
#signupFormWrapper{display:none;}
.input-group{margin-bottom:14px;text-align:left;}
.input-group label{display:block;font-size:12px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;}
.input-group input{width:100%;padding:13px 16px;border:1.5px solid #E5E7EB;border-radius:14px;font-size:15px;outline:none;}
.input-group input:focus{border-color:var(--primary);}
.divider{text-align:center;color:#9CA3AF;font-size:13px;margin:8px 0;}
</style>
</head>
<body>
<div class="hero">
  <img src="https://images.unsplash.com/photo-1530521954074-e64f6810b32d?w=800&q=80" alt="Travel">
  <div class="hero-overlay"></div>
  <div class="hero-brand">
    <div class="logo-row">
      <div class="logo-circle">✈️</div>
      <div>
        <h1>Sriwijaya Voyage</h1>
        <p>Jelajahi Nusantara Bersama Kami</p>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div id="mainButtons">
    <h2>Selamat Datang!</h2>
    <p>Pesan penerbangan, hotel, dan wisata favoritmu.</p>
    <a href="login.php" class="btn btn-primary">Masuk</a>
    <button class="btn btn-outline" id="showSignupBtn">Daftar Akun</button>
  </div>

  <!-- Sign Up form (inline) -->
  <div id="signupFormWrapper">
    <h2>Buat Akun Baru</h2>
    <p>Sudah punya akun? <a href="login.php" style="color:var(--primary);font-weight:700;">Masuk di sini</a></p>
    <form id="signupForm">
      <div class="input-group">
        <label>Nama Lengkap</label>
        <input type="text" id="su_name" placeholder="Nama kamu" required>
      </div>
      <div class="input-group">
        <label>Email</label>
        <input type="email" id="su_email" placeholder="email@example.com" required>
      </div>
      <div class="input-group">
        <label>Password</label>
        <input type="password" id="su_pass" placeholder="Min. 6 karakter" required>
      </div>
      <button type="submit" class="btn btn-primary">Buat Akun</button>
      <button type="button" class="btn btn-outline" id="cancelSignup">Kembali</button>
    </form>
  </div>
</div>

<!-- Success Modal -->
<div class="modal-overlay" id="successModal">
  <div class="modal-box">
    <div class="icon">🎉</div>
    <h3>Akun Berhasil Dibuat!</h3>
    <p>Selamat bergabung di Sriwijaya Voyage. Silakan masuk untuk memulai perjalananmu.</p>
    <a href="login.php" class="btn btn-primary">Masuk Sekarang</a>
  </div>
</div>

<script>
const showSignupBtn = document.getElementById('showSignupBtn');
const cancelSignup  = document.getElementById('cancelSignup');
const mainButtons   = document.getElementById('mainButtons');
const signupWrapper = document.getElementById('signupFormWrapper');
const successModal  = document.getElementById('successModal');

showSignupBtn.onclick = () => {
  mainButtons.style.display   = 'none';
  signupWrapper.style.display = 'block';
};
cancelSignup.onclick = () => {
  signupWrapper.style.display = 'none';
  mainButtons.style.display   = 'block';
};
document.getElementById('signupForm').onsubmit = (e) => {
  e.preventDefault();
  successModal.classList.add('open');
};
window.addEventListener('click', e => {
  if (e.target === successModal) successModal.classList.remove('open');
});
</script>
</body>
</html>