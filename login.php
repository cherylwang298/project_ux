<?php
require 'config.php';

if (auth()) { header('Location: home.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $u = getUserByEmail($email);

    if ($u && ($pass === 'password' || password_verify($pass, $u['password']))) {
        $_SESSION['user'] = [
            'id'=>$u['id'], 'name'=>$u['name'], 'email'=>$u['email'],
            'phone'=>$u['phone'], 'role'=>$u['role']
        ];

        if (!isset($_SESSION['_user_seeded'][$u['id']])) {
            global $DEMO_BOOKINGS, $DEMO_FAVOURITES;
            if (!isset($_SESSION['bookings'])) $_SESSION['bookings'] = [];
            if (!isset($_SESSION['favourites'])) $_SESSION['favourites'] = [];
            if ((int)$u['id'] === 2) {
                foreach ($DEMO_BOOKINGS as $ref => $b) $_SESSION['bookings'][$ref] = $b;
                $_SESSION['favourites'][2] = [1,4];
            }
            $_SESSION['_user_seeded'][$u['id']] = true;
        }

        header('Location: home.php');
        exit;
    }

    $error = 'Incorrect email or password.';
}

echo htmlHead("Sign In", <<<CSS
@keyframes bgFloat{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(20px,-20px) scale(1.06)}}
.bg1{animation:bgFloat 12s ease-in-out infinite}.bg2{animation:bgFloat 15s ease-in-out infinite reverse}
.auth-field{position:relative}.auth-icon{position:absolute!important;left:22px!important;top:50%!important;transform:translateY(-50%)!important;color:#7b8496!important;font-size:22px!important;line-height:1!important;pointer-events:none!important;z-index:5!important}.auth-eye{position:absolute!important;right:22px!important;top:50%!important;transform:translateY(-50%)!important;color:#7b8496!important;z-index:6!important}.input-f{width:100%!important;height:52px!important;padding-left:72px!important;padding-right:64px!important;border-radius:0!important;background:rgba(255,255,255,.78)!important;border:1.5px solid rgba(120,130,155,.55)!important;outline:none!important;font-size:15px!important;font-family:'Plus Jakarta Sans',sans-serif!important;color:#111c2d!important;transition:all .25s ease!important;box-sizing:border-box!important}.input-f::placeholder{color:#8b93a3!important}.input-f:focus{border-color:#004ce2!important;background:#fff!important;box-shadow:0 0 0 4px rgba(0,76,226,.10)!important}
CSS);
?>
<body class="bg-background min-h-screen flex items-center justify-center p-5 overflow-hidden">
<div class="fixed top-[-15%] left-[-10%] w-[55vw] h-[55vw] rounded-full bg-primary-fixed/30 blur-[130px] -z-10 pointer-events-none bg1"></div>
<div class="fixed bottom-[-15%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-secondary-fixed/25 blur-[110px] -z-10 pointer-events-none bg2"></div>

<div class="w-full max-w-md">
  <div class="text-center mb-8 anim-fade-up">
    <a href="home.php" class="inline-flex items-center gap-2 mb-4">
      <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings:'FILL' 1,'wght' 700">flight_takeoff</span>
      <span class="text-3xl font-extrabold tracking-tight text-on-surface">Stay<span class="text-primary">Go</span></span>
    </a>
    <h1 class="text-2xl font-extrabold text-on-surface">Welcome Back</h1>
    <p class="text-on-surface-variant mt-1 text-sm">Sign in to continue your journey.</p>
  </div>

  <div class="glass rounded-3xl p-8 anim-scale delay-100">
    <?php if ($error): ?>
      <div class="mb-5 p-3.5 rounded-xl bg-error-container border border-error/30 flex items-center gap-2">
        <span class="material-symbols-outlined text-error icon-fill text-[18px]">error</span>
        <p class="text-sm text-error font-semibold"><?= h($error) ?></p>
      </div>
    <?php endif; ?>

    <form method="POST" id="loginForm">
      <div class="space-y-4 mb-6">
        <div>
          <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider">Email</label>
          <div class="auth-field">
            <span class="material-symbols-outlined auth-icon">mail</span>
            <input class="input-f" type="email" name="email" placeholder="email@example.com" value="<?= h($_POST['email'] ?? '') ?>" required autocomplete="email" style="padding-left:72px!important;padding-right:64px!important;">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-on-surface-variant mb-2 uppercase tracking-wider">Password</label>
          <div class="auth-field">
            <span class="material-symbols-outlined auth-icon">lock</span>
            <input class="input-f" type="password" name="password" id="pwd" placeholder="••••••••" required autocomplete="current-password" style="padding-left:72px!important;padding-right:64px!important;">
            <button type="button" onclick="togglePwd()" class="auth-eye"><span class="material-symbols-outlined text-[20px]" id="eyeIcon">visibility</span></button>
          </div>
        </div>
      </div>

      <button type="submit" id="submitBtn" class="w-full h-14 rounded-full bg-gradient-to-r from-primary to-secondary-container text-white font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 hover:scale-[1.02] active:scale-[.98] transition-all group">
        <span class="material-symbols-outlined text-[20px]">login</span><span id="btnTxt">Sign In</span><span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
      </button>
    </form>

    <div class="mt-5 text-center"><p class="text-sm text-on-surface-variant">No account yet? <a href="daftar_akun.php" class="text-primary font-bold hover:opacity-75 transition-opacity">Sign Up</a></p></div>
  </div>

  <div class="mt-5 glass rounded-2xl p-4 anim-fade-up delay-300">
    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-primary icon-fill">info</span>Demo Accounts — Password: <code class="bg-primary-fixed px-1.5 py-0.5 rounded text-primary">password</code></p>
    <div class="space-y-1.5">
      <?php foreach (getUsers() as $u): ?>
        <button type="button" onclick="fillDemo('<?= h($u['email']) ?>')" class="w-full text-left px-3 py-2 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 transition-all flex items-center gap-3">
          <span class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary-container text-white font-bold text-xs flex items-center justify-center shrink-0"><?= h(strtoupper(substr($u['name'],0,1))) ?></span>
          <div class="min-w-0"><p class="text-xs font-bold text-on-surface"><?= h($u['name']) ?> <span class="text-outline font-normal">(<?= h($u['role']) ?>)</span></p><p class="text-xs text-outline truncate"><?= h($u['email']) ?></p></div>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
function fillDemo(email){document.querySelector('[name=email]').value=email;document.querySelector('[name=password]').value='password'}
function togglePwd(){const input=document.getElementById('pwd');const icon=document.getElementById('eyeIcon');input.type=input.type==='password'?'text':'password';icon.textContent=input.type==='password'?'visibility':'visibility_off'}
document.getElementById('loginForm').onsubmit=()=>{const btn=document.getElementById('submitBtn');btn.disabled=true;document.getElementById('btnTxt').textContent='Signing In...'};
</script>
</body>
</html>
