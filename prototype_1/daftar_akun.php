<?php
require 'config.php';

if (auth()) { header('Location: home.php'); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $conf  = $_POST['confirm_password'] ?? '';

    if (!$name) $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email is invalid.';
    if (getUserByEmail($email)) $errors[] = 'Email is already registered.';
    if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($pass !== $conf) $errors[] = 'Password confirmation does not match.';

    if (!$errors) {
        global $USERS;
        $newId = max(array_keys($USERS)) + 1;
        $USERS[$newId] = ['id'=>$newId,'name'=>$name,'email'=>$email,'phone'=>$phone,'role'=>'user','password'=>password_hash($pass, PASSWORD_DEFAULT)];
        $_SESSION['user'] = ['id'=>$newId,'name'=>$name,'email'=>$email,'phone'=>$phone,'role'=>'user'];
        $_SESSION['_user_seeded'][$newId] = true;
        flashSet('success','Account created successfully! Welcome to StayGo.');
        header('Location: home.php'); exit;
    }
}

echo htmlHead("Sign Up", <<<CSS
@keyframes bgFloat{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(18px,-18px) scale(1.05)}}
.bg1{animation:bgFloat 12s ease-in-out infinite}.bg2{animation:bgFloat 16s ease-in-out infinite reverse}
.auth-field{position:relative}.auth-icon{position:absolute!important;left:22px!important;top:50%!important;transform:translateY(-50%)!important;color:#7b8496!important;font-size:22px!important;line-height:1!important;pointer-events:none!important;z-index:5!important}.auth-eye{position:absolute!important;right:22px!important;top:50%!important;transform:translateY(-50%)!important;color:#7b8496!important;z-index:6!important}.input-f{width:100%!important;height:52px!important;padding-left:72px!important;padding-right:64px!important;border-radius:0!important;background:rgba(255,255,255,.78)!important;border:1.5px solid rgba(120,130,155,.55)!important;outline:none!important;font-size:15px!important;font-family:'Plus Jakarta Sans',sans-serif!important;color:#111c2d!important;transition:all .25s ease!important;box-sizing:border-box!important}.input-f::placeholder{color:#8b93a3!important}.input-f:focus{border-color:#004ce2!important;background:#fff!important;box-shadow:0 0 0 4px rgba(0,76,226,.10)!important}.input-f.err{border-color:#ba1a1a!important}.strength-bar{height:4px;border-radius:9999px;transition:width .4s ease,background .4s ease}
CSS);
?>
<body class="bg-background min-h-screen flex items-center justify-center p-5 overflow-hidden">
<div class="fixed top-[-15%] right-[-10%] w-[55vw] h-[55vw] rounded-full bg-primary-fixed/25 blur-[130px] -z-10 pointer-events-none bg1"></div>
<div class="fixed bottom-[-15%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-secondary-fixed/20 blur-[110px] -z-10 pointer-events-none bg2"></div>

<div class="w-full max-w-md">
  <div class="text-center mb-8 anim-fade-up">
    <a href="home.php" class="inline-flex items-center gap-2 mb-4"><span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings:'FILL' 1,'wght' 700">flight_takeoff</span><span class="text-3xl font-extrabold tracking-tight text-on-surface">Stay<span class="text-primary">Go</span></span></a>
    <h1 class="text-2xl font-extrabold text-on-surface">Create Account</h1>
    <p class="text-on-surface-variant text-sm mt-1">Join StayGo and start your journey.</p>
  </div>

  <div class="glass rounded-3xl p-8 anim-scale delay-100">
    <?php if ($errors): ?><div class="mb-5 p-4 rounded-xl bg-error-container border border-error/30"><?php foreach($errors as $e): ?><p class="text-sm text-error flex items-center gap-1.5 mb-1"><span class="material-symbols-outlined icon-fill text-[14px]">error</span><?= h($e) ?></p><?php endforeach; ?></div><?php endif; ?>

    <form method="POST" id="regForm" class="space-y-4">
      <div><label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Full Name *</label><div class="auth-field"><span class="material-symbols-outlined auth-icon">person</span><input class="input-f <?= in_array('Full name is required.', $errors, true) ? 'err' : '' ?>" type="text" name="name" placeholder="Sarah Jenkins" value="<?= h($_POST['name'] ?? '') ?>" required style="padding-left:72px!important;padding-right:64px!important;"></div></div>
      <div><label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Email *</label><div class="auth-field"><span class="material-symbols-outlined auth-icon">mail</span><input class="input-f" type="email" name="email" placeholder="email@example.com" value="<?= h($_POST['email'] ?? '') ?>" required style="padding-left:72px!important;padding-right:64px!important;"></div></div>
      <div><label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Phone</label><div class="auth-field"><span class="material-symbols-outlined auth-icon">phone</span><input class="input-f" type="tel" name="phone" placeholder="+62 812 xxxx xxxx" value="<?= h($_POST['phone'] ?? '') ?>" style="padding-left:72px!important;padding-right:64px!important;"></div></div>
      <div><label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Password *</label><div class="auth-field"><span class="material-symbols-outlined auth-icon">lock</span><input class="input-f" type="password" name="password" id="pwd" placeholder="Minimum 6 characters" required oninput="checkStrength(this.value)" style="padding-left:72px!important;padding-right:64px!important;"><button type="button" onclick="togglePassword('pwd','eye1')" class="auth-eye"><span class="material-symbols-outlined text-[20px]" id="eye1">visibility</span></button></div><div class="mt-2 h-1.5 bg-surface-container rounded-full overflow-hidden"><div class="strength-bar bg-primary" id="strengthBar" style="width:0%"></div></div><p class="text-xs text-outline mt-1" id="strengthTxt">Enter your password</p></div>
      <div><label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Confirm Password *</label><div class="auth-field"><span class="material-symbols-outlined auth-icon">lock_reset</span><input class="input-f" type="password" name="confirm_password" id="cpwd" placeholder="Repeat your password" required style="padding-left:72px!important;padding-right:64px!important;"><button type="button" onclick="togglePassword('cpwd','eye2')" class="auth-eye"><span class="material-symbols-outlined text-[20px]" id="eye2">visibility</span></button></div></div>
      <button type="submit" class="w-full h-14 rounded-full bg-gradient-to-r from-primary to-secondary-container text-white font-bold text-sm flex items-center justify-center gap-2 shadow-lg hover:scale-[1.02] active:scale-[.98] transition-all group mt-2"><span class="material-symbols-outlined text-[20px]">person_add</span>Create Account<span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span></button>
    </form>

    <p class="text-center text-sm text-on-surface-variant mt-5">Already have an account? <a href="login.php" class="text-primary font-bold hover:opacity-75 transition-opacity">Sign In</a></p>
  </div>
</div>
<script>
function togglePassword(inputId,iconId){const input=document.getElementById(inputId);const icon=document.getElementById(iconId);input.type=input.type==='password'?'text':'password';icon.textContent=input.type==='password'?'visibility':'visibility_off'}
function checkStrength(value){const bar=document.getElementById('strengthBar');const text=document.getElementById('strengthTxt');let score=0;if(value.length>=6)score++;if(value.length>=10)score++;if(/[A-Z]/.test(value))score++;if(/[0-9]/.test(value))score++;if(/[^a-zA-Z0-9]/.test(value))score++;if(value.length===0){bar.style.width='0%';text.textContent='Enter your password';return}const levels=[[20,'#ba1a1a','Weak'],[40,'#ff9800','Fair'],[60,'#ffc107','Medium'],[80,'#4caf50','Strong'],[100,'#2e7d32','Very Strong']];const [w,c,l]=levels[Math.min(score,4)];bar.style.width=w+'%';bar.style.background=c;text.textContent=l}
</script>
</body>
</html>
