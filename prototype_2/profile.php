<?php
session_start();
require '_data.php';
require '_head.php';
if(!isset($_SESSION['saved_guest'])) $_SESSION['saved_guest']=['name'=>'Ceri Wijaya','email'=>'ceri@email.com','phone'=>'+62 812-3456-7890'];
$g=$_SESSION['saved_guest'];

// Handle edit
if($_SERVER['REQUEST_METHOD']==='POST'){
  $_SESSION['saved_guest']=['name'=>$_POST['name']??$g['name'],'email'=>$_POST['email']??$g['email'],'phone'=>$_POST['phone']??$g['phone']];
  $g=$_SESSION['saved_guest'];
  $saved=true;
}
?>
<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<title>Profil — StayEase</title><?=$font?><?=$css?>
</head><body>

<?=header_bar('Profil')?>

<div class="page-content" style="padding-bottom:90px;">

  <!-- Profile hero -->
  <div style="text-align:center;padding:16px 0 24px;">
    <div style="position:relative;display:inline-block;margin-bottom:14px;">
      <div style="width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,#5B5FEF,#7C3AED);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:800;color:#fff;box-shadow:0 8px 24px rgba(91,95,239,0.35);margin:0 auto;">
        <?=strtoupper(substr($g['name'],0,1))?>
      </div>
      <div style="position:absolute;bottom:0;right:0;width:26px;height:26px;border-radius:50%;background:#fff;border:2px solid #fff;display:flex;align-items:center;justify-content:center;font-size:13px;box-shadow:0 2px 8px rgba(0,0,0,.15);cursor:pointer;" onclick="toggleModal('editModal')">✏️</div>
    </div>
    <div style="font-size:20px;font-weight:800;letter-spacing:-0.5px;"><?=htmlspecialchars($g['name'])?></div>
    <div style="font-size:13px;color:var(--c-text2);margin-top:3px;"><?=htmlspecialchars($g['email'])?></div>
    <div style="font-size:12px;color:var(--c-text3);margin-top:2px;"><?=htmlspecialchars($g['phone'])?></div>
    <?php if(!empty($saved)): ?>
    <div style="display:inline-flex;align-items:center;gap:5px;background:var(--c-green-soft);border:1px solid var(--c-green-border);border-radius:20px;padding:5px 14px;font-size:11px;color:var(--c-green);font-weight:700;margin-top:10px;">✓ Perubahan tersimpan</div>
    <?php endif; ?>
  </div>

  <!-- Stats -->
  <div class="glass" style="border-radius:var(--r-xl);padding:16px 20px;margin-bottom:16px;display:flex;justify-content:space-around;text-align:center;">
    <div><div style="font-size:22px;font-weight:900;color:var(--c-accent);letter-spacing:-0.5px;"><?=count($_SESSION['orders']??[])?></div><div style="font-size:10px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px;">Pesanan</div></div>
    <div style="width:1px;background:rgba(0,0,0,0.07);"></div>
    <div><div style="font-size:22px;font-weight:900;color:var(--c-accent);letter-spacing:-0.5px;"><?=count($_SESSION['contacts']??[['x']])?></div><div style="font-size:10px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px;">Kontak Tersimpan</div></div>
    <div style="width:1px;background:rgba(0,0,0,0.07);"></div>
    <div><div style="font-size:22px;font-weight:900;color:var(--c-accent);letter-spacing:-0.5px;">2</div><div style="font-size:10px;color:var(--c-text3);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px;">Favorit</div></div>
  </div>

  <!-- Menu -->
  <div class="profile-menu glass" style="border-radius:var(--r-xl);margin-bottom:12px;">
    <a href="orders.php" class="profile-menu-item">
      <div class="pmenu-icon" style="background:rgba(91,95,239,0.1);">📋</div>
      <span class="pmenu-label">Pesanan Saya</span>
      <span class="pmenu-badge"><?=count($_SESSION['orders']??[])?></span>
      <span class="pmenu-arrow">›</span>
    </a>
    <div class="profile-menu-item" onclick="toggleModal('contactsModal')">
      <div class="pmenu-icon" style="background:rgba(0,200,150,0.1);">👥</div>
      <span class="pmenu-label">Data Tamu Tersimpan</span>
      <span class="pmenu-arrow">›</span>
    </div>
    <div class="profile-menu-item" onclick="toggleModal('editModal')">
      <div class="pmenu-icon" style="background:rgba(255,149,0,0.1);">✏️</div>
      <span class="pmenu-label">Edit Profil</span>
      <span class="pmenu-arrow">›</span>
    </div>
    <div class="profile-menu-item">
      <div class="pmenu-icon" style="background:rgba(91,95,239,0.1);">🔔</div>
      <span class="pmenu-label">Notifikasi</span>
      <span class="pmenu-arrow">›</span>
    </div>
    <div class="profile-menu-item">
      <div class="pmenu-icon" style="background:rgba(255,77,106,0.1);">🛡️</div>
      <span class="pmenu-label">Privasi & Keamanan</span>
      <span class="pmenu-arrow">›</span>
    </div>
    <div class="profile-menu-item" style="border-bottom:none;">
      <div class="pmenu-icon" style="background:rgba(0,0,0,0.05);">❓</div>
      <span class="pmenu-label">Bantuan</span>
      <span class="pmenu-arrow">›</span>
    </div>
  </div>

  <div style="text-align:center;padding:8px 0;">
    <div style="font-size:12px;color:var(--c-red);font-weight:700;cursor:pointer;padding:12px;">Keluar Akun</div>
    <div style="font-size:10px;color:var(--c-text3);margin-top:4px;">StayEase v3.0 · Dibuat dengan 💜</div>
  </div>
</div>

<!-- Edit modal -->
<div class="modal-overlay" id="editModal" onclick="closeModal('editModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()">
    <div class="modal-handle"></div>
    <div class="modal-title">Edit Profil</div>
    <form method="POST">
      <div class="form-card glass" style="border-radius:var(--r-lg);overflow:hidden;margin-bottom:14px;">
        <div class="form-group"><div class="form-label-row">Nama Lengkap</div><input class="form-input" type="text" name="name" value="<?=htmlspecialchars($g['name'])?>" required></div>
        <div class="form-group"><div class="form-label-row">Email</div><input class="form-input" type="email" name="email" value="<?=htmlspecialchars($g['email'])?>"></div>
        <div class="form-group" style="border-bottom:none;"><div class="form-label-row">Nomor HP</div><input class="form-input" type="tel" name="phone" value="<?=htmlspecialchars($g['phone'])?>"></div>
      </div>
      <button type="submit" class="btn-primary" style="margin-bottom:10px;">Simpan Perubahan</button>
      <button type="button" class="btn-outline" onclick="closeModal('editModal')">Batal</button>
    </form>
  </div>
</div>

<!-- Contacts modal -->
<div class="modal-overlay" id="contactsModal" onclick="closeModal('contactsModal')">
  <div class="modal-sheet" onclick="event.stopPropagation()" style="max-height:80vh;overflow-y:auto;">
    <div class="modal-handle"></div>
    <div class="modal-title">Data Tamu Tersimpan</div>
    <div class="contact-list" style="margin-bottom:12px;">
      <?php foreach(($_SESSION['contacts']??[['name'=>'Ceri Wijaya','email'=>'ceri@email.com','phone'=>'+62 812-3456-7890','color'=>'#5B5FEF']]) as $c): ?>
      <div class="contact-item" style="cursor:default;">
        <div class="contact-av" style="background:<?=$c['color']?>"><?=strtoupper(substr($c['name'],0,1))?></div>
        <div class="contact-info">
          <div class="contact-name"><?=htmlspecialchars($c['name'])?></div>
          <div class="contact-detail"><?=htmlspecialchars($c['email'])?> · <?=htmlspecialchars($c['phone'])?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="button" class="btn-outline" onclick="closeModal('contactsModal')">Tutup</button>
  </div>
</div>

<?=nav('profile')?>
<script src="assets/app.js"></script>
</body></html>
